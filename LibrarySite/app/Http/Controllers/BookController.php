<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\BookReview;
use App\Models\BookRating;
use App\Models\Stock;
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

        $books= Book::with('stock')
        ->whereHas('Stock',function ($query){
            $query->where('quantity', '>=', 1);
        })
        ->paginate(9);

       

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
            'author_id' => 'required|exists:authors,id',
            'language' => 'required|string|max:255',
            'page_count' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'isbn' => 'required|string|max:13',
            'publisher_id' => 'required|exists:publishers,id',
            'publish_year' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $existingBook = Book::where('isbn', $request->isbn)->first();

        if ($existingBook) {
            Stock::where('book_id', $existingBook->id)->increment('quantity', $request->Quantity);
            return redirect()->route('admin.listBooks')
                ->with('info', 'Bu kitap stokta zaten mevcut. Stok miktarı güncellendi.');
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
        $book = Book::with(['category', 'comments.user', 'ratings'])->findOrFail($id);
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
        if ($book->stock) {
            $book->stock->delete();
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
        $quantity = $request->input('quantity');

        // Tümünü silme
        if ($quantity === 'all') {
            if ($book->stock) {
                $book->stock->delete();
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
            
            return response()->json([
                'success' => true,
                'remaining' => 0,
                'message' => 'Kitap başarıyla silindi.'
            ]);
        }

        // Bir kısmı silme
        $quantity = (int)$quantity;
        if ($book->stock) {
            $currentQuantity = $book->stock->quantity;
            if ($quantity >= $currentQuantity) {
                $book->stock->delete();
                $book->delete();
                return response()->json([
                    'success' => true,
                    'remaining' => 0,
                    'message' => 'Kitap başarıyla silindi.'
                ]);
            } else {
                // Stoktan düş
                $book->stock->quantity -= $quantity;
                $book->stock->save();
                return response()->json([
                    'success' => true,
                    'remaining' => $book->stock->quantity,
                    'message' => 'Stok güncellendi.'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'İşlem gerçekleştirilemedi.'
        ], 400);
    }
}
