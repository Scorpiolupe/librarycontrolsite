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

Route::get('/adminpanel', [AdminController::class, 'index'])->name('admin.index');
Route::get('/adminpanel/create-book', [AdminController::class, 'createBook'])->name('admin.createBook');
Route::get('/adminpanel/list-books', [AdminController::class, 'listBooks'])->name('admin.listBooks');
Route::get('/adminpanel/manage-categories', [AdminController::class, 'manageCategories'])->name('admin.manageCategories');
Route::get('/adminpanel/manage-authors', [AdminController::class, 'manageAuthors'])->name('admin.manageAuthors');
Route::post('/adminpanel/create-author', [AdminController::class, 'createAuthor'])->name('admin.createAuthor');
Route::get('/adminpanel/manage-publishers', [AdminController::class, 'managePublishers'])->name('admin.managePublishers');
Route::post('/adminpanel/create-publisher', [AdminController::class, 'createPublisher'])->name('admin.createPublisher');
Route::get('/adminpanel/manage-copies', [AdminController::class, 'manageCopies'])->name('admin.manageCopies');
Route::get('/adminpanel/create-copy', [AdminController::class, 'createCopy'])->name('admin.createCopy');
Route::post('/adminpanel/store-copy', [AdminController::class, 'storeCopy'])->name('admin.storeCopy');
Route::get('/adminpanel/edit-copy/{id}', [AdminController::class, 'editCopy'])->name('admin.editCopy');
Route::post('/adminpanel/update-copy/{id}', [AdminController::class, 'updateCopy'])->name('admin.updateCopy');
Route::delete('/adminpanel/copies/{id}', [AdminController::class, 'deleteCopy'])->name('admin.deleteCopy');
Route::get('/adminpanel/books/{bookId}/isbns', [AdminController::class, 'getBookIsbns']);
Route::post('/adminpanel/copies/{id}/borrow', [AdminController::class, 'borrowBook'])->name('admin.borrowBook');
Route::post('/adminpanel/copies/{id}/return', [AdminController::class, 'returnBook'])->name('admin.returnBook');
Route::get('/adminpanel/copies/{id}/due-date', [AdminController::class, 'getDueDate'])->name('admin.getDueDate');
Route::post('/adminpanel/copies/{id}/extend', [AdminController::class, 'extendDueDate'])->name('admin.extendDueDate');
Route::get('/adminpanel/users/search', [AdminController::class, 'searchUsers']);


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
Route::get('/adminpanel/manage-borrowings', [AdminController::class, 'manageBorrowings'])->name('admin.manageBorrowings');

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

Route::middleware(['auth'])->group(function () {
    Route::post('/books/{id}/request-borrow', [BookController::class, 'requestBorrow'])->name('books.requestBorrow');
    Route::post('/admin/borrow-requests/{id}/update', [AdminController::class, 'updateBorrowRequest'])->name('admin.updateBorrowRequest');
    Route::get('/admin/borrow-requests', [AdminController::class, 'borrowRequests'])->name('admin.borrowRequests');
});




