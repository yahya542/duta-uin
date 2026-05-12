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
        $putra = Candidate::where('category', 'putra')->orderBy('total_votes', 'desc')->get();
        $putri = Candidate::where('category', 'putri')->orderBy('total_votes', 'desc')->get();
        $totalVotes = Vote::where('status', 'approved')->sum('vote_point');
        
        return view('welcome', compact('putra', 'putri', 'totalVotes'));
    }

    /**
     * Show candidates for admin.
     */
    public function adminIndex()
    {
        $candidates = Candidate::all();
        return view('admin.candidates.index', compact('candidates'));
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

        return redirect()->back()->with('success', 'Candidate added successfully.');
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

        event(new VoteUpdated(
            Candidate::orderBy('total_votes', 'desc')->get(),
            Vote::where('status', 'approved')->sum('vote_point')
        ));

        return redirect()->back()->with('success', 'Candidate updated successfully.');
    }
}
