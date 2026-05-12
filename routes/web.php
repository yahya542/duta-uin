<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', [CandidateController::class, 'index'])->name('home');
Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
Route::get('/payment/{vote_id}', [VoteController::class, 'showPayment'])->name('payment');
Route::post('/payment/{vote_id}/upload', [VoteController::class, 'uploadProof'])->name('payment.upload');
Route::get('/success', function () {
    return view('success');
})->name('success');

// Auth Routes (Login)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Candidates Management
    Route::get('/candidates', [CandidateController::class, 'adminIndex'])->name('admin.candidates.index');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('admin.candidates.store');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('admin.candidates.update');
    
    // Transactions Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::post('/transactions/{id}/approve', [TransactionController::class, 'approve'])->name('admin.transactions.approve');
    Route::post('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('admin.transactions.reject');
});
