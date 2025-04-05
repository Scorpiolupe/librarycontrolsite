<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function createBook()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function listBooks()
    {
        $books = Book::all();
        return view('admin.books.list', compact('books'));
    }

    public function manageCategories()
    {
        return view('admin.categories.index');
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
