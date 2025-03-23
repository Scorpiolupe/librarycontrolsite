<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;

Route::get('/', [PageController::class, 'index']);
Route::get('/discover', [PageController::class, 'discover']);
Route::get('/auth', [PageController::class, 'auth']);

Route::get('/friends', [FriendController::class, 'index']);

Route::get('/adminpanel', [AdminController::class, 'index']);

Route::post('/kayit', [RegisterController::class, 'register']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/{id}/rate', [BookController::class, 'rate'])->middleware('auth');
Route::post('/books/{id}/comment', [BookController::class, 'comment'])->middleware('auth');
