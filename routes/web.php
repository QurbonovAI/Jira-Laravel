<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'))->name('home');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::resource('projects', ProjectController::class);
    Route::resource('issues', IssueController::class);
    Route::post('/issues/complete', [IssueController::class, 'complete'])->name('issues.complete');
    Route::resource('penalties', PenaltyController::class)->only(['index', 'store']);
    Route::resource('team', TeamController::class)->only(['index']);
    Route::resource('reports', ReportController::class)->only(['index']);
});
