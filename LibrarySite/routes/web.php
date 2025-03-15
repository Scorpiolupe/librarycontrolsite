<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index']);
Route::get('/discover', [PageController::class, 'discover']);
Route::get('/auth', [PageController::class, 'auth']);


Route::get('/friends', [FriendController::class, 'index']);

Route::get('/adminpanel', [AdminController::class, 'index']);