<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\BorrowedBook;
use App\Models\Activity;

class AdminController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $borrowedBooks = BorrowedBook::count();
        $recentActivities = Activity::latest()->take(10)->get();

        return view('admin', compact('totalBooks', 'totalUsers', 'totalCategories', 'borrowedBooks', 'recentActivities'));
    }
}
