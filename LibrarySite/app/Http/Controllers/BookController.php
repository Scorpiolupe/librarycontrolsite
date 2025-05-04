<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\BookReview;
use App\Models\BookRating;
use App\Models\BorrowRequest;
use App\Models\BookCopy;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // BookCopy modelinden başlayıp book ilişkisini yüklüyoruz
        $query = BookCopy::with(['book' => function($q) {
            // Book ile ilişkili diğer modelleri de yüklüyoruz
            $q->with(['category', 'genres', 'author']);
        }]);

        // Arama filtresi - kitap adı veya yazar adına göre
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereHas('book', function($q) use ($search) {
                $q->where('book_name', 'like', "%{$search}%")
                  ->orWhereHas('author', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Kategori filtresi
        if ($request->has('category')) {
            $query->whereHas('book', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Tür filtresi
        if ($request->has('genre')) {
            $query->whereHas('book.genres', function($q) use ($request) {
                $q->where('genre_id', $request->genre);
            });
        }

        // Sayfa sayısı filtresi
        if ($request->has('page_count_min') && $request->has('page_count_max')) {
            $query->whereHas('book', function($q) use ($request) {
                $q->whereBetween('page_count', [
                    $request->page_count_min, 
                    $request->page_count_max
                ]);
            });
        }

        // Kopyaları paginate ile getir
        $copies = $query->paginate(9);
        $categories = Category::all();
        $genres = Genre::all();

        return view('books', compact('copies', 'categories', 'genres'));
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
            'author_id' => 'required|exists:authors,id',
            'language_id' => 'required|exists:languages,id',
            'page_count' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:13|unique:books,isbn',
            'publisher_id' => 'required|exists:publishers,id',
            'publish_year' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $existingBook = Book::where('isbn', $request->isbn)->first();

        if ($existingBook) {
            return redirect()->back()->with('error', 'Bu ISBN numarasına sahip bir kitap zaten mevcut.');
        }

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('storage/books'), $imageName);
            $data['image'] = 'books/' . $imageName;
        }

        $book = Book::create($data);


        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'book_creation',
            'activity_description' => 'Created book: ' . $request->book_name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.listBooks')->with('success', 'Kitap başarıyla oluşturuldu.');
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

        return view('books', compact('books', 'categories', 'genres'));
    }

    public function show($id)
    {
        $book = Book::with(['category', 'comments.user', 'ratings', 'bookCopies', 'publisher', 'author', 'genres'])->findOrFail($id);
        $book->average_rating = $book->ratings()->avg('rating') ?? 0;
        $book->ratings_count = $book->ratings()->count();
        
        if (Auth::check()) {
            $book->user_rating = $book->ratings()
                ->where('user_id', Auth::id())
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
            'user_id' => Auth::id(),
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

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $languages = Language::all();
        
        return view('admin.books.edit', compact('book', 'categories', 'authors', 'publishers', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_name' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'language_id' => 'required|exists:languages,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:13|unique:books,isbn,'.$id,
            'page_count' => 'required|integer',
            'publish_year' => 'required|integer',
            'description' => 'nullable|string'
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('admin.listBooks')->with('success', 'Kitap başarıyla güncellendi.');
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kitap başarıyla silindi.'
        ]);
    }

    public function destroy(Book $book)
    {
        foreach ($book->bookCopies as $copy) {
            $copy->stockHistories()->delete();
            $copy->delete();
        }

        if ($book->ratings) {
            $book->ratings()->delete();
        }
        if ($book->comments) {
            $book->comments()->delete();
        }
        if ($book->image) {
            $imagePath = public_path('storage/' . $book->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

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

    public function toggleStatus($id)
    {
        $book = Book::findOrFail($id);
        $book->status = $book->status === 'available' ? 'borrowed' : 'available';
        $book->save();

        return response()->json([
            'success' => true,
            'newStatus' => $book->status,
            'message' => 'Kitap durumu başarıyla güncellendi.'
        ]);
    }

    public function ajaxDelete($id, Request $request)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json([
            'success' => true,
            'message' => 'Kitap başarıyla silindi.'
        ]);
    }

    
}

