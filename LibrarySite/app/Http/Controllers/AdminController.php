<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
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
        $publishers = Publisher::all();
        $authors = Author::all();
        $languages = Language::all();
        return view('admin.books.create', compact('categories', 'publishers', 'authors', 'languages')); 
    }

    public function listBooks()
    {
        $books = Book::with('category', 'genres')->paginate(10);
        
        return view('admin.books.list', compact('books'));
    }

    public function manageAuthors()
    {
        $authors = Author::all();
        return view('admin.books.authors', compact('authors'));
    }

    public function createAuthor(Request $request)
    {
        $author = new Author();
        $author->name = $request->name;
        $author->biography = $request->biography;
        $author->image = $request->image;
        $author->website = $request->website;
        $author->save();

        return redirect()->route('admin.manageAuthors')->with('success', 'Yazar başarıyla eklendi.');
    }

    public function managePublishers()
    {
        $publishers = Publisher::all();
        return view('admin.books.publishers', compact('publishers'));
    }

    public function createPublisher(Request $request)
    {
        $publisher = new Publisher();
        $publisher->name = $request->name;
        $publisher->address = $request->address;
        $publisher->phone = $request->phone;
        $publisher->email = $request->email;
        $publisher->website = $request->website;
        $publisher->logo = $request->logo;
        $publisher->description = $request->description;
        $publisher->save();

        return redirect()->route('admin.managePublishers')->with('success', 'Yayınevi başarıyla eklendi.');
    }

    public function manageCategories()
    {
        $categories = Category::all();;
        return view('admin.books.categories', compact('categories'));     
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
