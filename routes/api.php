<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoController;
 
Route::get('/todo', [TodoController::class, 'index']);
Route::post('/todo/add', [TodoController::class, 'add']);
Route::post('/todo/update', [TodoController::class, 'update']);
Route::post('/todo/delete', [TodoController::class, 'delete']);