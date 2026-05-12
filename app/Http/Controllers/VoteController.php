<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Transaction;
use App\Services\VoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Show payment page for a specific candidate.
     */
    public function showPayment($candidate_id)
    {
        $candidate = Candidate::findOrFail($candidate_id);
        return view('payment', compact('candidate'));
    }

    /**
     * Store the vote and transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'voter_name' => 'required|string|max:255',
            'nominal' => 'required|integer',
            'vote_point' => 'required|integer',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $candidate = Candidate::findOrFail($request->candidate_id);

            // Create Vote
            $vote = Vote::create([
                'candidate_id' => $candidate->id,
                'user_id' => Auth::id(),
                'voter_name' => $request->voter_name,
                'nominal' => $request->nominal,
                'vote_point' => $request->vote_point,
                'status' => 'pending',
            ]);

            // Save Proof
            $path = $request->file('proof_image')->store('proofs', 'public');

            // Create Transaction
            Transaction::create([
                'vote_id' => $vote->id,
                'candidate_id' => $candidate->id,
                'nominal' => $request->nominal,
                'proof_image' => $path,
                'status' => 'pending',
            ]);

            // Redirect with URLs
            $waNumber = '6281932551947';
            $message = "Halo Admin,\nSaya sudah transfer voting.\n\nNama: {$vote->voter_name}\nKandidat: {$candidate->name}\nNominal: Rp" . number_format($vote->nominal, 0, ',', '.');
            $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($message);
            $gformUrl = "https://forms.gle/vLRtuTee8izHMPfp7";

            return view('success', [
                'waUrl' => $waUrl,
                'gformUrl' => $gformUrl
            ]);
        });
    }
}
