<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate(9);
        $categories = Category::all();
        $genres = Genre::all();

        return view('books', compact('books', 'categories', 'genres'));
    }

    public function create()
    {
        $categories = Category::all();
        $genres = Genre::all();
        return view('books.create', compact('categories', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_name' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'page_count' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:13|unique:books',
            'publisher' => 'required|string|max:255',
            'publish_year' => 'required|integer',
            'status' => 'required|string|max:255',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla oluşturuldu.');
    }

    public function books(Request $request)
    {
        $query = Book::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('genre')) {
            $query->where('genre_id', $request->genre);
        }

        $books = $query->paginate(9);
        $categories = Category::all();
        $genres = Genre::all();

        return view('books', compact('books', 'categories', 'genres'));
    }
}
