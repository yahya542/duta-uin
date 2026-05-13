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
     * Show top-up page.
     */
    public function showTopUp()
    {
        return view('topup');
    }

    /**
     * Store the top-up transaction.
     */
    public function storeTopUp(Request $request)
    {
        $request->validate([
            'nominal' => 'required|integer',
            'vote_point' => 'required|integer',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'voter_name' => 'required|string|max:255',
        ]);

        return DB::transaction(function () use ($request) {
            // Create a placeholder Vote record for the transaction
            // In the new system, 'Vote' model might represent a TopUp request
            $vote = Vote::create([
                'candidate_id' => null, // Not voting yet
                'user_id' => Auth::id(),
                'voter_name' => $request->voter_name,
                'nominal' => $request->nominal,
                'vote_point' => $request->vote_point,
                'status' => 'pending',
            ]);

            $path = $request->file('proof_image')->store('proofs', 'public');

            Transaction::create([
                'vote_id' => $vote->id,
                'candidate_id' => null,
                'nominal' => $request->nominal,
                'proof_image' => $path,
                'status' => 'pending',
            ]);

            $waNumber = '6281932551947';
            $message = "Halo Admin,\nSaya sudah transfer Top Up Poin.\n\nNama: {$vote->voter_name}\nNominal: Rp" . number_format($vote->nominal, 0, ',', '.');
            $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($message);
            $gformUrl = "https://forms.gle/vLRtuTee8izHMPfp7";

            return view('success', [
                'waUrl' => $waUrl,
                'gformUrl' => $gformUrl
            ]);
        });
    }

    /**
     * Cast a direct vote using user points.
     */
    public function castVote(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'points' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $candidate = Candidate::findOrFail($request->candidate_id);

        if ($user->points <= 0) {
            return redirect()->route('topup.index')->with('error', 'Poin Anda habis. Silakan lakukan Top Up terlebih dahulu.');
        }

        if ($user->points < $request->points) {
            return back()->with('error', 'Poin tidak mencukupi.');
        }

        try {
            $success = $this->voteService->castVote($user, $candidate, $request->points);

            if ($success) {
                return redirect()->route('home')->with('success', "Berhasil memberikan {$request->points} vote untuk {$candidate->name}!");
            }
        } catch (\Exception $e) {
            \Log::error('Vote casting failed: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }

        return back()->with('error', 'Terjadi kesalahan saat melakukan voting.');
    }
}
