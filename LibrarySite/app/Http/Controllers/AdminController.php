<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\BookCopy;
use App\Models\User;
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
        $totalBooks = Book::count();
        $totalCopies = BookCopy::count();
        $totalUsers = User::count();
        $totalActivities = Activity::count();
        $totalBorrowedBooks = BookCopy::where('status', 'borrowed')->count();
        $totalAvailableBooks = BookCopy::where('status', 'available')->count();

        $activities = Activity::all();
        return view('admin', compact('activities', 'totalBooks', 'totalCopies', 'totalUsers', 'totalActivities', 'totalBorrowedBooks', 'totalAvailableBooks'));
    }

    public function createBook()
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors = Author::all();
        $languages = Language::all();
        return view('admin.books.create', compact('categories', 'publishers', 'authors', 'languages')); 
    }

    public function manageStocks(Request $request)
    {
        $sort = $request->get('sort', 'name');
        
        if ($sort == 'name') {
            $books = Book::select('book_name')
                ->selectRaw('COUNT(book_copies.id) as copies_count')
                ->leftJoin('book_copies', 'books.id', '=', 'book_copies.book_id')
                ->groupBy('book_name')
                ->orderBy('book_name');
        } else {
            $books = Book::select('book_name', 'isbn')
                ->withCount('bookCopies as copies_count')
                ->orderBy('isbn');
        }

        $books = $books->get();
        return view('admin.stocks.manage-stocks', compact('books', 'sort'));
    }

    public function listBooks()
    {
        $books = Book::with('category', 'genres', 'bookCopy')->paginate(10);
        
        return view('admin.books.list', compact('books'));
    }

    public function manageCopies() {
        $copies= BookCopy::with('book')->paginate(10);
        return view('admin.books.copies', compact('copies'));
    }

    public function createCopy()
    {
        $books = Book::select('book_name')
            ->distinct()
            ->get();
        return view('admin.books.create-copy', compact('books'));
    }

    public function storeCopy(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'shelf_location' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'acquisition_source' => 'nullable|in:Satın Alım,Bağış',
            'acquisition_cost' => 'nullable|numeric',
            'condition' => 'required|in:yıpranmış,az yıpranmış,yıpranmış,çok yıpranmış',
            'status' => 'required|in:available,borrowed,reserved,lost',
        ]);

        BookCopy::create($request->all());

        return redirect()->route('admin.manageCopies')->with('success', 'Kitap kopyası başarıyla eklendi.');
    }

    public function editCopy($id)
    {
        $copy = BookCopy::findOrFail($id);
        $books = Book::all();
        return view('admin.books.edit-copy', compact('copy', 'books'));
    }

    public function updateCopy(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'shelf_location' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'acquisition_source' => 'nullable|string|max:255',
            'acquisition_cost' => 'nullable|numeric',
            'status' => 'required|in:available,borrowed,reserved,lost',
        ]);

        $copy = BookCopy::findOrFail($id);
        $copy->update($request->all());

        return redirect()->route('admin.manageCopies')->with('success', 'Kitap kopyası başarıyla güncellendi.');
    }

    public function deleteCopy($id)
    {
        $copy = BookCopy::findOrFail($id);
        $copy->delete();

        return response()->json(['success' => true]);
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

    public function getBookIsbns($bookName)
    {
        $books = Book::where('book_name', $bookName)
            ->with('publisher')
            ->get();

        if ($books->isEmpty()) {
            return response()->json(['error' => 'Kitap bulunamadı']);
        }

        $result = [];
        foreach ($books as $book) {
            $result[] = [
                'id' => $book->id,
                'isbn' => $book->isbn,
                'publisher' => $book->publisher->name ?? 'Bilinmiyor'
            ];
        }

        return response()->json(['books' => $result]);
    }
}
