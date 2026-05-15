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
use App\Http\Controllers\Admin\UserController;

// Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login',    [StudentAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [StudentAuthController::class, 'login']);
    Route::get('/register', [StudentAuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[StudentAuthController::class, 'register']);

    Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

Route::post('/logout', [StudentAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Student Routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard',               [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/scholarships',            [ScholarshipController::class, 'index'])->name('scholarships');
    Route::get('/scholarships/{id}',       [ScholarshipController::class, 'show'])->name('scholarships.show');
    Route::post('/bookmarks/{id}',         [BookmarkController::class, 'store'])->name('bookmark');
    Route::delete('/bookmarks/{id}',       [BookmarkController::class, 'destroy'])->name('unbookmark');
    Route::get('/bookmarks',               [BookmarkController::class, 'index'])->name('bookmarks');
    Route::get('/notifications',           [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{id}/read',[DashboardController::class, 'markRead'])->name('notifications.read');
    Route::get('/profile',                 [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile',                 [DashboardController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',    [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/scholarships', [AdminScholarship::class, 'index'])->name('scholarships');
    Route::post('/sync',        [SyncController::class, 'sync'])->name('sync');
    Route::get('/sync-logs',    [SyncController::class, 'logs'])->name('sync-logs');
    Route::get('/students',     [UserController::class, 'index'])->name('students');
});