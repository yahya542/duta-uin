<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_votes' => Vote::where('status', 'success')->sum('vote_point'),
            'total_revenue' => Transaction::where('status', 'success')->sum('nominal'),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'total_candidates' => Candidate::count(),
        ];

        $recentTransactions = Transaction::with(['candidate', 'vote'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions'));
    }
}
