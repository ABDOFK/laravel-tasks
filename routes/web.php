<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/tasks');



Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('tasks');
    Route::get('/statistics', [TaskController::class, 'statistics'])->name('tasks.statistics');


    Route::get('/create', [TaskController::class, 'create'])->name('createTask');
    Route::post('/', [TaskController::class, 'store'])->name('formTask');
    Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('editTask');
    Route::put('/{id}', [TaskController::class, 'update'])->name('updateTask');
    Route::delete('/{id}', [TaskController::class, 'destroy'])->name('deleteTask');
});





