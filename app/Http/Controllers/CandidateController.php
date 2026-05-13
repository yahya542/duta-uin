<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use App\Events\VoteUpdated;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Show the homepage.
     */
    public function index()
    {
        $totalPutra = Candidate::where('category', 'putra')->sum('total_votes');
        $totalPutri = Candidate::where('category', 'putri')->sum('total_votes');
        
        $putra = Candidate::where('category', 'putra')->orderBy('total_votes', 'desc')->get();
        $putri = Candidate::where('category', 'putri')->orderBy('total_votes', 'desc')->get();

        // Calculate dynamic percentages relative to category total
        $putra->map(function ($c) use ($totalPutra) {
            $c->percentage = $totalPutra > 0 ? ($c->total_votes / $totalPutra) * 100 : 0;
            return $c;
        });

        $putri->map(function ($c) use ($totalPutri) {
            $c->percentage = $totalPutri > 0 ? ($c->total_votes / $totalPutri) * 100 : 0;
            return $c;
        });
        
        $totalApprovedVotes = Vote::where('status', 'approved')->sum('vote_point');
        
        return view('welcome', [
            'putra' => $putra,
            'putri' => $putri,
            'totalVotes' => $totalApprovedVotes
        ]);
    }

    /**
     * Show candidates for admin.
     */
    public function adminIndex(Request $request)
    {
        $query = Candidate::query();
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $candidates = $query->orderBy('category')->orderBy('total_votes', 'desc')->get();
        $stats = [
            'total' => $candidates->count(),
            'putra' => $candidates->where('category', 'putra')->count(),
            'putri' => $candidates->where('category', 'putri')->count(),
            'votes' => $candidates->sum('total_votes'),
        ];

        return view('admin.candidates.index', compact('candidates', 'stats'));
    }

    /**
     * Store new candidate (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:putra,putri',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'category', 'description']);
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidate::create($data);

        return redirect()->back()->with('success', 'Kandidat berhasil ditambahkan.');
    }

    /**
     * Update candidate (Admin).
     */
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:putra,putri',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'total_votes' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'category', 'description', 'total_votes']);
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($data);

        // Recalculate and trigger update for real-time
        $all = Candidate::orderBy('total_votes', 'desc')->get();
        $total = Vote::where('status', 'approved')->sum('vote_point');

        event(new VoteUpdated($all, $total));

        return redirect()->back()->with('success', 'Data kandidat berhasil diperbarui.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->back()->with('success', 'Kandidat berhasil dihapus.');
    }
}
