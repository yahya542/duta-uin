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
        $candidates = Candidate::orderBy('total_votes', 'desc')->get();
        $totalVotes = Vote::where('status', 'approved')->sum('vote_point');
        
        // Podium logic
        $podium = $candidates->take(3);
        
        return view('welcome', compact('candidates', 'totalVotes', 'podium'));
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
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);
        
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
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'total_votes' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'description', 'total_votes']);
        
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
