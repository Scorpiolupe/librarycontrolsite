<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::get('/', [PageController::class, 'index']);
Route::get('/discover', [PageController::class, 'discover']);
Route::get('/auth', [PageController::class, 'auth']);

Route::get('/friends', [FriendController::class, 'index']);

Route::get('/adminpanel', [AdminController::class, 'index']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/{id}/rate', [BookController::class, 'rate'])->middleware('auth');
Route::post('/books/{id}/comment', [BookController::class, 'comment'])->middleware('auth');

Route::post('/kayit', [RegisterController::class, 'register']);
Route::post('/giris', [RegisterController::class, 'login']);
Route::get('/cikis', [RegisterController::class, 'logout']);

Route::post('/login', [RegisterController::class, 'login'])->name('login');
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

// Add routes for books, categories, users, and roles
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);

Route::get('/profilim', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profilim/avatar', [ProfileController::class, 'updateAvatar'])->middleware('auth');




