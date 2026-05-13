<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Vote;
use App\Models\Transaction;
use App\Models\User;
use App\Models\LeaderboardLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_votes' => Candidate::sum('total_votes'),
            'total_revenue' => Transaction::where('status', 'success')->sum('nominal'),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
            'total_candidates' => Candidate::count(),
            'total_users' => User::where('role', 'voter')->count(),
        ];

        $recentTransactions = Transaction::with(['candidate', 'vote'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $topCandidates = Candidate::orderBy('total_votes', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'topCandidates'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total_users' => User::count(),
            'voters' => User::where('role', 'voter')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'total_points' => User::sum('points'),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function leaderboard()
    {
        $putra = Candidate::where('category', 'putra')->orderBy('total_votes', 'desc')->get();
        $putri = Candidate::where('category', 'putri')->orderBy('total_votes', 'desc')->get();
        $totalVotes = Candidate::sum('total_votes');

        return view('admin.leaderboard', compact('putra', 'putri', 'totalVotes'));
    }

    public function activity(Request $request)
    {
        $search = $request->search;

        $transactionsQuery = Transaction::with(['vote', 'candidate'])->latest();
        $votesQuery = Vote::with(['user', 'candidate'])->latest();
        $logsQuery = LeaderboardLog::with('candidate')->latest();

        if ($search) {
            $transactionsQuery->where(function($q) use ($search) {
                $q->whereHas('vote', function($sq) use ($search) {
                    $sq->where('voter_name', 'like', '%' . $search . '%');
                })->orWhereHas('candidate', function($sq) use ($search) {
                    $sq->where('name', 'like', '%' . $search . '%');
                });
            });

            $votesQuery->where(function($q) use ($search) {
                $q->whereHas('user', function($sq) use ($search) {
                    $sq->where('name', 'like', '%' . $search . '%');
                })->orWhereHas('candidate', function($sq) use ($search) {
                    $sq->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $transactions = $transactionsQuery->take(20)->get();
        $votes = $votesQuery->take(20)->get();
        $logs = $logsQuery->take(20)->get();

        return view('admin.activity', compact('transactions', 'votes', 'logs'));
    }
}
