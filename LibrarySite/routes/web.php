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
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/discover', [PageController::class, 'discover']);
Route::get('/auth', [PageController::class, 'auth']);

Route::get('/friends', [FriendController::class, 'index']);

Route::prefix('adminpanel')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/create-book', [AdminController::class, 'createBook'])->name('admin.createBook');
    Route::get('/list-books', [AdminController::class, 'listBooks'])->name('admin.listBooks');
    Route::get('/manage-categories', [AdminController::class, 'manageCategories'])->name('admin.manageCategories');
    Route::get('/manage-authors', [AdminController::class, 'manageAuthors'])->name('admin.manageAuthors');
    Route::post('/create-author', [AdminController::class, 'createAuthor'])->name('admin.createAuthor');
    Route::get('/manage-publishers', [AdminController::class, 'managePublishers'])->name('admin.managePublishers');
    Route::post('/create-publisher', [AdminController::class, 'createPublisher'])->name('admin.createPublisher');
    Route::get('/manage-copies', [AdminController::class, 'manageCopies'])->name('admin.manageCopies');

    Route::get('/create-copy', [AdminController::class, 'createCopy'])->name('admin.createCopy');
    Route::post('/store-copy', [AdminController::class, 'storeCopy'])->name('admin.storeCopy');
    Route::get('/edit-copy/{id}', [AdminController::class, 'editCopy'])->name('admin.editCopy');
    Route::post('/update-copy/{id}', [AdminController::class, 'updateCopy'])->name('admin.updateCopy');
    Route::delete('/copies/{id}', [AdminController::class, 'deleteCopy'])->name('admin.deleteCopy');

    Route::get('/books/{bookId}/isbns', [AdminController::class, 'getBookIsbns']);
});

Route::post('/adminpanel/create-category', [CategoryController::class, 'create'])->name('admin.createCategory');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);
Route::get('/logout', [RegisterController::class, 'logout']);

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
Route::post('/books/create', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/{id}/rate', [BookController::class, 'rate'])->middleware('auth');
Route::post('/books/{id}/comment', [BookController::class, 'comment'])->middleware('auth');
Route::post('/books/{copyId}/borrow', [BookController::class, 'borrowBook'])->name('books.borrow');
Route::post('/books/{copyId}/return', [BookController::class, 'returnBook'])->name('books.return');

Route::get('/adminpanel/manage-stocks', [AdminController::class, 'manageStocks'])->name('admin.manageStocks');

// Yeni route tanımlamaları
Route::delete('/adminpanel/books/{id}/delete', [BookController::class, 'ajaxDelete'])->name('books.ajaxDelete');
Route::post('/adminpanel/books/{id}/toggle-status', [BookController::class, 'toggleStatus'])->name('books.toggleStatus');
Route::get('/adminpanel/addBook/', [BookController::class, 'addBook'])->name('books.addBook');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->middleware('auth');

Route::post('/friends/add', [FriendController::class, 'add'])->name('friends.add');

Route::get('/api/genres', function (Request $request) {
    $categoryId = $request->get('category_id');
    $genres = Genre::where('category_id', $categoryId)->get();
    return response()->json($genres);
});




