<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Transaction;
use App\Services\VoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Store the initial vote request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'voter_name' => 'required|string|max:255',
            'nominal' => 'required|integer|in:5000,10000,25000,50000,100000,250000',
        ]);

        $vote = Vote::create([
            'candidate_id' => $request->candidate_id,
            'voter_name' => $request->voter_name,
            'nominal' => $request->nominal,
            'vote_point' => $this->voteService->calculatePoints($request->nominal),
            'status' => 'pending',
        ]);

        return redirect()->route('payment', ['vote_id' => $vote->id]);
    }

    /**
     * Show payment page.
     */
    public function showPayment(Request $request)
    {
        $vote = Vote::with('candidate')->findOrFail($request->vote_id);
        return view('payment', compact('vote'));
    }

    /**
     * Handle proof upload.
     */
    public function uploadProof(Request $request, $vote_id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $vote = Vote::findOrFail($vote_id);

        $path = $request->file('proof_image')->store('proofs', 'public');

        Transaction::create([
            'vote_id' => $vote->id,
            'candidate_id' => $vote->candidate_id,
            'nominal' => $vote->nominal,
            'proof_image' => $path,
            'status' => 'pending',
        ]);

        // WhatsApp Redirect logic
        $waNumber = '6281932551947';
        $message = "Halo Admin,\nSaya sudah transfer voting.\n\nNama: {$vote->voter_name}\nKandidat: {$vote->candidate->name}\nNominal: Rp" . number_format($vote->nominal, 0, ',', '.');
        $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($message);

        // Google Form Redirect logic
        $gformUrl = "https://forms.gle/vLRtuTee8izHMPfp7";

        return view('success', [
            'waUrl' => $waUrl,
            'gformUrl' => $gformUrl
        ]);
    }
}
