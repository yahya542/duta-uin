<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [CandidateController::class, 'index'])->name('home');
Route::get('/api/candidates/{candidate}/voters', [CandidateController::class, 'getVoters'])->name('api.candidates.voters');

// Voting Protected Routes
Route::middleware('auth')->group(function () {
    // Top Up
    Route::get('/topup', [VoteController::class, 'showTopUp'])->name('topup.index');
    Route::post('/topup', [VoteController::class, 'storeTopUp'])->name('topup.store');
    
    // Direct Voting
    Route::post('/vote/cast', [VoteController::class, 'castVote'])->name('votes.cast');

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/tutorial', function () {
    return \Inertia\Inertia::render('Tutorial');
})->name('tutorial');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('admin.users.index');
    Route::put('/users/{user}', [DashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [DashboardController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->name('admin.leaderboard');
    Route::get('/activity', [DashboardController::class, 'activity'])->name('admin.activity');
    Route::get('/api/search-data', [\App\Http\Controllers\Admin\SearchApiController::class, 'getData'])->name('admin.api.search');
    Route::get('/api/candidate-voters/{candidate}', [DashboardController::class, 'getCandidateVoters'])->name('admin.api.candidate-voters');
    
    // Candidates Management
    Route::get('/candidates', [CandidateController::class, 'adminIndex'])->name('admin.candidates.index');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('admin.candidates.store');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('admin.candidates.destroy');
    
    // Transactions Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::post('/transactions/{id}/approve', [TransactionController::class, 'approve'])->name('admin.transactions.approve');
    Route::post('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('admin.transactions.reject');
});
