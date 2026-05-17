<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ScholarshipController;
use App\Http\Controllers\Student\BookmarkController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ScholarshipController as AdminScholarship;
use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\Admin\SyncLogController;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/browse', [ScholarshipController::class, 'publicIndex'])->name('browse');

Route::get('/about', function () {
    return view('public.about');
})->name('about');

// ─── Guest-only Auth Routes ───────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [StudentAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [StudentAuthController::class, 'login']);

    Route::get('/register',  [StudentAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [StudentAuthController::class, 'register']);

    Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::post('/logout', [StudentAuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─── Student Routes ───────────────────────────────────────────────────────────

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/scholarships',      [ScholarshipController::class, 'index'])->name('scholarships');
    Route::get('/scholarships/{id}', [ScholarshipController::class, 'show'])->name('scholarships.show');

    Route::post('/bookmarks/{id}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::get('/bookmarks',              [BookmarkController::class, 'index'])->name('bookmarks');
    Route::post('/bookmarks/{id}',        [BookmarkController::class, 'store'])->name('bookmark');
    Route::delete('/bookmarks/{id}',      [BookmarkController::class, 'destroy'])->name('unbookmark');

    Route::get('/notifications',                [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read',     [DashboardController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/toggle-alerts', [DashboardController::class, 'toggleAlerts'])->name('notifications.toggle');

    Route::get('/profile',  [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile',  [DashboardController::class, 'updateProfile'])->name('profile.update');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Scholarship management
    Route::get('/scholarships',                    [AdminScholarship::class, 'index'])->name('scholarships');
    Route::patch('/scholarships/{id}/toggle',      [AdminScholarship::class, 'toggle'])->name('scholarships.toggle');

    // Sync Now — GET = page, POST = run sync (called via JS fetch)
    Route::get('/sync',  [SyncController::class, 'index'])->name('sync');
    Route::post('/sync', [SyncController::class, 'run'])->name('sync.run');

    // Sync Logs
    Route::get('/sync-logs', [SyncController::class, 'logs'])->name('sync-logs');
}); // ─── Architecture Diagram ─────────────────────────────────────────────────────

Route::get('/architecture', function () {
    return view('architecture');
})->name('architecture');
