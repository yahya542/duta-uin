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
            $transaction->update(['status' => 'approved']);
            
            $vote = $transaction->vote;
            $vote->update(['status' => 'approved']);

            // Update total_votes on candidate first
            $candidate = $vote->candidate;
            $candidate->increment('total_votes', $vote->vote_point);

            $this->refreshStatistics();
            
            event(new VoteUpdated(
                Candidate::orderBy('total_votes', 'desc')->get(),
                Vote::where('status', 'approved')->sum('vote_point')
            ));
        });
    }
}
