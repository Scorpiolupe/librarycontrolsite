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
use Illuminate\Http\Request;
use App\Models\Genre;

Route::get('/', [PageController::class, 'index']);
Route::get('/discover', [PageController::class, 'discover']);
Route::get('/auth', [PageController::class, 'auth']);

Route::get('/friends', [FriendController::class, 'index']);

Route::get('/adminpanel', [AdminController::class, 'index']);
Route::get('/adminpanel/create-book', [AdminController::class, 'createBook'])->name('admin.createBook');
Route::get('/adminpanel/list-books', [AdminController::class, 'listBooks'])->name('admin.listBooks');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);
Route::get('/logout', [RegisterController::class, 'logout']);

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::post('/books/create', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/{id}/rate', [BookController::class, 'rate'])->middleware('auth');
Route::post('/books/{id}/comment', [BookController::class, 'comment'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->middleware('auth');

Route::get('/api/genres', function (Request $request) {
    $categoryId = $request->get('category_id');
    $genres = Genre::where('category_id', $categoryId)->get();
    return response()->json($genres);
});




