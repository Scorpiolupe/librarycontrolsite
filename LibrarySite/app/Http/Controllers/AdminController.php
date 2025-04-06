<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\Category;
use App\Models\Stock;
use Database\Seeders\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->is_admin == 0) {
            return back()->with('error', 'Bu sayfaya erişim izniniz yok.');
        }

        $activities = Activity::all();
        return view('admin', compact('activities'));
    }

    public function createBook()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function listBooks()
    {
        $books = Book::with('category', 'genres', 'stock')->paginate(10);
        
        return view('admin.books.list', compact('books'));
    }

    public function manageCategories()
    {
        $categories = Category::all();;
        return view('admin.categories.index', compact('categories'));     
    }

    public function addUser()
    {
        return view('admin.members.add');
    }

    public function listUsers()
    {
        return view('admin.members.list');
    }

    public function userRoles()
    {
        return view('admin.members.roles');
    }

}
