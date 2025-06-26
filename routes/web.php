<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProgressUpdateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public welcome page
Route::get('/', function () {
    return view('welcome', [
        'totalProblems' => \App\Models\Problem::count(),
        'solvedProblems' => \App\Models\Problem::where('status', 'resolved')->count(),
        'activeUsers' => \App\Models\User::count(),
    ]);
})->name('home');

// User dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::resource('problems', ProblemController::class);
    Route::post('/problems/{problem}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/problems/{problem}/vote', [VoteController::class, 'vote'])->name('problems.vote');
    Route::post('/problems/{problem}/progress', [ProgressUpdateController::class, 'store'])->name('progress.store');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Authority-only routes
Route::middleware(['auth', 'role:authority'])->group(function () {
    Route::get('/problems/{problem}/manage', [ProblemController::class, 'manage'])->name('problems.manage');
    Route::post('/problems/{problem}/assign', [ProblemController::class, 'assign'])->name('problems.assign');
});

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.updateRole');
    Route::post('/users/{user}/ban', [AdminController::class, 'toggleBan'])->name('admin.users.toggleBan');

    // Problems
    Route::get('/problems', [AdminController::class, 'problems'])->name('admin.problems');
    Route::post('/problems/{problem}/assign', [AdminController::class, 'assignProblem'])->name('admin.problems.assign');
    Route::post('/problems/{problem}/status', [AdminController::class, 'updateStatus'])->name('admin.problems.status');

    // Admin Analytics & Reports
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

require __DIR__.'/auth.php';
