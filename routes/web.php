<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clients', ClientController::class);

Route::post('clients/{client}/interactions', [InteractionController::class, 'store'])
    ->name('interactions.store');
Route::delete('interactions/{interaction}', [InteractionController::class, 'destroy'])
    ->name('interactions.destroy');

Route::resource('deals', DealController::class)->except(['show']);
Route::post('deals/{deal}/status', [DealController::class, 'updateStatus'])
    ->name('deals.updateStatus');

Route::resource('tasks', TaskController::class);
Route::post('tasks/{task}/toggle', [TaskController::class, 'toggle'])
    ->name('tasks.toggle');
