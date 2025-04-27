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
use App\Models\BorrowedBook;
<<<<<<< Updated upstream
use App\Models\BorrowRequest;
use App\Models\ShelfLocation;
use Database\Seeders\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
=======
use Database\Seeders\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
>>>>>>> Stashed changes

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

    public function manageCopies(Request $request) {
        $search = $request->search;
        
        $copies = BookCopy::with('book')
            ->when($search, function($query) use ($search) {
                $query->whereHas('book', function($q) use ($search) {
                    $q->where('isbn', 'like', '%'.$search.'%');
                })->orWhere('barcode', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.books.copies', compact('copies'));
    }

    public function manageBorrowings(Request $request) {
        $search = $request->search;
        
        $copies = BookCopy::with('book')
            ->when($search, function($query) use ($search) {
                $query->whereHas('book', function($q) use ($search) {
                    $q->where('isbn', 'like', '%'.$search.'%');
                })->orWhere('barcode', 'like', '%'.$search.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.stocks.manage-borrowings', compact('copies'));
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
            'block' => 'required|in:A,B',
            'floor' => 'required|in:0,1,2',
            'row' => 'required|integer|min:1|max:21',
            'shelf' => 'required|integer|min:1|max:20',
            'position' => 'required|integer|min:1|max:150',
            'shelf_location' => 'nullable|string|max:255',
            'acquisition_date' => 'nullable|date',
            'acquisition_source' => 'nullable|in:Satın Alım,Bağış',
            'acquisition_cost' => 'nullable|numeric',
            'condition' => 'required|in:yıpranmamış,az yıpranmış,yıpranmış,çok yıpranmış',
            'status' => 'required|in:available,borrowed,reserved,lost',
        ]);

        try {
            DB::beginTransaction();

            // Formatlı raf konumu oluştur
            $formattedLocation = sprintf(
                "%s-%d-%d-%d-%d",
                $request->block,
                $request->floor,
                $request->row,
                $request->shelf,
                $request->position
            );

            // Kitap kopyasını oluştur
            $bookCopy = BookCopy::create([
                'book_id' => $request->book_id,
                'shelf_location' => $formattedLocation, // Formatlı konumu kaydet
                'status' => $request->status,
                'condition' => $request->condition,
                'acquisition_date' => $request->acquisition_date,
                'acquisition_source' => $request->acquisition_source,
                'acquisition_cost' => $request->acquisition_cost,
            ]);

            // Detaylı raf konumu bilgisini kaydet
            ShelfLocation::create([
                'book_copy_id' => $bookCopy->id,
                'block' => $request->block,
                'floor' => $request->floor,
                'row' => $request->row,
                'shelf' => $request->shelf,
                'position' => $request->position
            ]);

            DB::commit();
            return redirect()->route('admin.manageCopies')
                ->with('success', 'Kitap kopyası başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Hata: ' . $e->getMessage());
        }
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

<<<<<<< Updated upstream
    public function manageBorrows()
    {
        $borrowedBooks = BorrowedBook::with(['user', 'bookCopy.book'])
            ->where('status', 'borrowed')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingCount = BorrowRequest::where('status', 'pending')->count();

        return view('admin.stocks.manage-borrowings', compact('borrowedBooks', 'pendingCount'));
    }

    public function borrowRequests()
    {
        $requests = BorrowRequest::with(['user', 'bookCopy.book'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.borrows.requests', compact('requests'));
    }

    public function updateBorrowRequest(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $borrowRequest = BorrowRequest::with('bookCopy.book')->findOrFail($id);
            
            if ($borrowRequest->status !== 'pending') {
                \DB::rollback();
                return back()->with('error', 'Bu istek zaten işlenmiş!');
            }

            if ($request->status === 'approved') {
                if (!$borrowRequest->bookCopy || $borrowRequest->bookCopy->status !== 'available') {
                    \DB::rollback();
                    return back()->with('error', 'Bu kitap kopyası artık müsait değil!');
                }

                $borrowRequest->bookCopy->update(['status' => 'borrowed']);
                
                BorrowedBook::create([
                    'user_id' => $borrowRequest->user_id,
                    'book_id' => $borrowRequest->bookCopy->book_id,
                    'purchase_date' => now(),
                    'return_date' => now()->addDays(15),
                    'status' => 'borrowed',
                    'delay_day' => 0,
                    'late_fee' => 0
                ]);
            }
            
            $borrowRequest->update(['status' => $request->status]);
            
            \DB::commit();
            return back()->with('success', 'İstek ' . ($request->status === 'approved' ? 'onaylandı' : 'reddedildi'));

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Bir hata oluştu: ' . $e->getMessage());
=======
    public function searchUsers(Request $request)
    {
        if($request->has('phone')) {
            $user = User::where('tel', 'LIKE', '%'.$request->phone.'%')->first();
            return response()->json(['user' => $user]);
        }

        $term = $request->get('term', '');
        $users = User::where('name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->get();
        return response()->json($users);
    }

    public function borrowBook(Request $request, $id)
    {
        $copy = BookCopy::findOrFail($id);
        $copy->status = 'borrowed';
        $copy->save();

        BorrowedBook::create([
            'copy_id' => $id,
            'user_id' => $request->user_id,
            'purchase_date' => now(),
            'return_date' => now()->addDays(14),
            'status' => 'borrowed'
        ]);

        return redirect()->route('admin.manageBorrowings')->with('success', 'Kitap başarıyla ödünç verildi.');
    }

    public function returnBook($id)
    {
        $copy = BookCopy::findOrFail($id);
        $copy->status = 'available';
        $copy->save();

        $borrowedBook = BorrowedBook::where('copy_id', $id)
            ->whereNull('returned_at')
            ->latest()
            ->first();

        if ($borrowedBook) {
            $returnedAt = now();
            $borrowedBook->returned_at = $returnedAt;
            $borrowedBook->status = 'returned';
            
            // Gecikme günü ve ceza hesaplama
            if ($returnedAt > $borrowedBook->return_date) {
                $delayDays = $returnedAt->diffInDays($borrowedBook->return_date);
                $borrowedBook->delay_day = $delayDays;
                $borrowedBook->late_fee = $delayDays * 5; // Günlük 5₺ ceza
            }
            
            $borrowedBook->save();
        }

        return response()->json(['success' => true]);
    }

    public function getDueDate($id)
    {
        $borrowedBook = BorrowedBook::where('copy_id', $id)
            ->whereNull('returned_at')
            ->latest()
            ->first();

        return response()->json([
            'due_date' => $borrowedBook ? $borrowedBook->due_date->format('d.m.Y') : null
        ]);
    }

    public function extendDueDate(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1'
        ]);

        $borrowedBook = BorrowedBook::where('copy_id', $id)
            ->whereNull('returned_at')
            ->where('status', 'borrowed')
            ->latest()
            ->first();

        if (!$borrowedBook) {
            return response()->json([
                'success' => false,
                'message' => 'Ödünç alma kaydı bulunamadı'
            ]);
        }

        try {
            $borrowedBook->return_date = $borrowedBook->return_date->addDays($request->days);
            $borrowedBook->save();

            return response()->json([
                'success' => true,
                'message' => 'Süre başarıyla uzatıldı'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Süre uzatma işlemi başarısız oldu'
            ]);
>>>>>>> Stashed changes
        }
    }
}
