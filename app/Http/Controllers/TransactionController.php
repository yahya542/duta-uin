<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\VoteService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Show pending transactions for admin.
     */
    public function index()
    {
        $transactions = Transaction::with(['candidate', 'vote'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'pending' => $transactions->where('status', 'pending')->count(),
            'success' => $transactions->where('status', 'success')->count(),
            'rejected' => $transactions->where('status', 'rejected')->count(),
            'revenue' => $transactions->where('status', 'success')->sum('nominal'),
        ];
            
        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    /**
     * Approve transaction.
     */
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->voteService->approveTransaction($transaction);

        return redirect()->back()->with('success', 'Transaction approved and vote counted.');
    }

    /**
     * Reject transaction.
     */
    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);
        $transaction->vote->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Transaction rejected.');
    }
}
