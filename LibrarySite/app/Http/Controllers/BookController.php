<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\BookReview;
use App\Models\BookRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('book_name', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genre_id', $request->genre);
            });
        }

        if ($request->has('page_count_min') && $request->has('page_count_max')) {
            $query->whereBetween('page_count', [$request->page_count_min, $request->page_count_max]);
        }

        $books = $query->paginate(9);
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
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genre_id', $request->genre);
            });
        }

        $books = $query->paginate(9);
        $categories = Category::all();
        $genres = Genre::all();

        return view('books', compact('books', 'categories', 'genres')); // Changed from 'books.index'
    }

    public function show($id)
    {
        $book = Book::with(['category', 'comments.user', 'ratings'])->findOrFail($id);
        $book->average_rating = $book->ratings()->avg('rating') ?? 0;
        $book->ratings_count = $book->ratings()->count();
        
        if (auth()->check()) {
            $book->user_rating = $book->ratings()
                ->where('user_id', auth()->id())
                ->first();
        }
        
        return view('book-detail', compact('book'));
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|min:3|max:1000'
        ]);

        BookReview::create([
            'user_id' => auth()->id(),
            'book_id' => $id,
            'comment' => $request->comment,
            'comment_date' => now()
        ]);

        return back()->with('success', 'Yorumunuz eklendi.');
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|numeric|between:0.5,5.0'
        ]);

        $book = Book::findOrFail($id);
        $existingRating = BookRating::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->first();
        if ($existingRating) {
            $existingRating->update(['rating' => $request->rating]);
        } else {
            $rating = BookRating::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                ['rating' => $request->rating]
            );
        }
        
        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'rating',
            'activity_description' => 'Rated book: ' . $book->book_name . ' with ' . $request->rating . ' stars',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        

        return back()->with('success', 'Puanınız kaydedildi.');
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        $genres = Genre::all();
        return view('books.edit', compact('book', 'categories', 'genres'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'genre_id' => 'required|exists:genres,id',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:13',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla güncellendi.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Kitap başarıyla silindi.');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $books = Book::where('book_name', 'like', "%{$query}%")
                     ->orWhere('author', 'like', "%{$query}%")
                     ->paginate(9);
                     
        $categories = Category::all();
        $genres = Genre::all();

        return view('books', compact('books', 'categories', 'genres'));

    }
}
