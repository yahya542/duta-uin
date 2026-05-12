<?php

namespace App\Services;

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
        return floor($nominal / 5000);
    }

    /**
     * Update candidate total votes and percentages for all candidates.
     */
    public function refreshStatistics()
    {
        $candidates = Candidate::orderBy('total_votes', 'desc')->get();
        $totalVotes = Vote::where('status', 'approved')->sum('vote_point');

        foreach ($candidates as $index => $candidate) {
            $candidateVotes = $candidate->votes()->where('status', 'approved')->sum('vote_point');
            $candidate->total_votes = $candidateVotes;
            $candidate->percentage = $totalVotes > 0 ? ($candidateVotes / $totalVotes) * 100 : 0;
            $candidate->save();

            // Log ranking (assuming candidates are ordered by votes)
            LeaderboardLog::create([
                'candidate_id' => $candidate->id,
                'total_votes' => $candidate->total_votes,
                'percentage' => $candidate->percentage,
                'ranking' => $index + 1,
            ]);
        }
    }

    /**
     * Approve a transaction and update associated vote.
     */
    public function approveTransaction(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {
            $transaction->update(['status' => 'approved']);
            
            $vote = $transaction->vote;
            $vote->update(['status' => 'approved']);

            $this->refreshStatistics();
            
            event(new VoteUpdated(
                Candidate::orderBy('total_votes', 'desc')->get(),
                Vote::where('status', 'approved')->sum('vote_point')
            ));
        });
    }
}
