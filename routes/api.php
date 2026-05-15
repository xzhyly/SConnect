<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// API Routes (JSON responses only)
Route::middleware(['auth'])->group(function () {

    // Admin-only API endpoints
    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::post('/sync', [AdminController::class, 'syncApi'])->name('api.admin.sync');
        Route::get('/stats', [AdminController::class, 'statsApi'])->name('api.admin.stats');
    });

    // Student API endpoints
    Route::post('/bookmarks/{id}', function ($id) {
        // Handled via StudentController — quick toggle endpoint
        return app(\App\Http\Controllers\StudentController::class)->bookmarkApi($id, request());
    })->name('api.bookmark');

});