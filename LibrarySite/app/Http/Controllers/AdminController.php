<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\BorrowedBook;

class AdminController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $borrowedBooks = BorrowedBook::count();
        $recentActivities = []; // Replace with actual recent activities logic

        return view('admin', compact('totalBooks', 'totalUsers', 'totalCategories', 'borrowedBooks', 'recentActivities'));
    }
}
