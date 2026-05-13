<?php

namespace App\Services;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Transaction;
use App\Models\LeaderboardLog;
use App\Events\VoteUpdated;
use Illuminate\Support\Facades\DB;

class VoteService
{
    /**
     * Calculate vote points based on nominal.
     */
    public function calculatePoints(int $nominal): int
    {
        return floor($nominal / 1000); // 1 point per 1000 IDR based on seeder logic
    }

    /**
     * Update candidate total votes and percentages for all candidates.
     */
    public function refreshStatistics()
    {
        $totalPutra = Candidate::where('category', 'putra')->sum('total_votes');
        $totalPutri = Candidate::where('category', 'putri')->sum('total_votes');
        
        $candidates = Candidate::all();

        foreach ($candidates as $candidate) {
            $categoryTotal = $candidate->category === 'putra' ? $totalPutra : $totalPutri;
            
            $candidate->percentage = $categoryTotal > 0 ? ($candidate->total_votes / $categoryTotal) * 100 : 0;
            $candidate->save();

            // Log ranking
            LeaderboardLog::create([
                'candidate_id' => $candidate->id,
                'total_votes' => $candidate->total_votes,
                'percentage' => $candidate->percentage,
                'ranking' => 0, // Simplified for now
            ]);
        }
    }

    /**
     * Approve a transaction and update associated vote.
     */
    public function approveTransaction(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            // Re-calculate points to prevent client-side manipulation
            $finalPoints = $this->calculatePoints($transaction->nominal);

            $transaction->update(['status' => 'success']);
            
            $vote = $transaction->vote;
            $vote->update([
                'status' => 'success',
                'vote_point' => $finalPoints
            ]);

            // ADD POINTS TO USER instead of candidate
            $user = $vote->user;
            if ($user) {
                $user->increment('points', $finalPoints);
            }

            // Statistics don't change until the user actually votes for a candidate
            // So we don't call refreshStatistics() or broadcast VoteUpdated here
        });
    }

    /**
     * Deduct points from user and add to candidate.
     */
    public function castVote(User $user, Candidate $candidate, int $points)
    {
        return DB::transaction(function () use ($user, $candidate, $points) {
            $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();
            $lockedCandidate = Candidate::whereKey($candidate->id)->lockForUpdate()->first();

            if (! $lockedUser || ! $lockedCandidate || $lockedUser->points < $points) {
                return false;
            }

            $lockedUser->decrement('points', $points);
            $lockedCandidate->increment('total_votes', $points);

            // LOG THE VOTE for transparency
            Vote::create([
                'candidate_id' => $candidate->id,
                'user_id' => $user->id,
                'voter_name' => $user->name,
                'nominal' => 0, // Direct vote from points
                'vote_point' => $points,
                'status' => 'success',
            ]);

            $this->refreshStatistics();
            
            event(new VoteUpdated(
                Candidate::orderBy('total_votes', 'desc')->get(),
                Candidate::sum('total_votes')
            ));

            return true;
        });
    }
}
