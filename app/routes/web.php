<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('index');

Route::prefix('/todos')->group(function() {
    Route::post('/', [TodoController::class, 'create'])->name('todos.create');
    Route::put('/', [TodoController::class, 'edit'])->name('todos.edit');
    Route::delete('/', [TodoController::class, 'delete'])->name('todos.delete');
});
