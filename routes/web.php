<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Task (Admin & User)
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::get('tasks-export/pdf', [TaskController::class, 'exportPdf'])->name('tasks.export.pdf');
    Route::get('tasks-export/excel', [TaskController::class, 'exportExcel'])->name('tasks.export.excel');
    Route::get('task-files/{taskFile}/download', [TaskController::class, 'downloadFile'])->name('task-files.download');
    Route::get('task-files/{taskFile}/preview', [TaskController::class, 'previewFile'])->name('task-files.preview');
    Route::delete('task-files/{taskFile}', [TaskController::class, 'deleteFile'])->name('task-files.destroy');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('priorities', PriorityController::class)->except(['show']);
        Route::resource('statuses', StatusController::class)->except(['show']);
    });
});

require __DIR__.'/auth.php';
