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

// ─── Guest-only Routes ────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::get('/browse', [ScholarshipController::class, 'publicIndex'])->name('browse');

    Route::get('/about', function () {
        return view('public.about');
    })->name('about');

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

// ─── Logout ───────────────────────────────────────────────────────────────────

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
    Route::post('/notifications/read-all',      [DashboardController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/toggle-alerts', [DashboardController::class, 'toggleAlerts'])->name('notifications.toggle');

    Route::get('/profile',  [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile',  [DashboardController::class, 'updateProfile'])->name('profile.update');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    Route::get('/scholarships',                [AdminScholarship::class, 'index'])->name('scholarships');
    Route::get('/scholarships/create',         [AdminScholarship::class, 'create'])->name('scholarships.create');
    Route::post('/scholarships',               [AdminScholarship::class, 'store'])->name('scholarships.store');
    Route::get('/scholarships/{id}/edit',      [AdminScholarship::class, 'edit'])->name('scholarships.edit');
    Route::put('/scholarships/{id}',           [AdminScholarship::class, 'update'])->name('scholarships.update');
    Route::delete('/scholarships/{id}',        [AdminScholarship::class, 'destroy'])->name('scholarships.destroy');
    Route::patch('/scholarships/{id}/toggle',  [AdminScholarship::class, 'toggle'])->name('scholarships.toggle');

    Route::get('/sync',         [SyncController::class, 'index'])->name('sync');
    Route::post('/sync',        [SyncController::class, 'run'])->name('sync.run');
    Route::post('/notify-all',  [SyncController::class, 'notifyAll'])->name('notify-all');

    Route::get('/sync-logs', [SyncController::class, 'logs'])->name('sync-logs');
});

// ─── Dev Only ─────────────────────────────────────────────────────────────────

Route::get('/architecture', function () {
    return view('architecture');
})->name('architecture');