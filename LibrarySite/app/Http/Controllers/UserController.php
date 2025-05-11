<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Models\BorrowedBook;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    public function userProfiles(Request $request)
    {
        $query = User::query();

        if ($request->has('search')) {
            $query->where('tcno', $request->search);
        }

        $users = $query->with(['borrowings' => function($query) {
            $query->orderBy('purchase_date', 'desc');
        }, 'borrowings.copy.book'])->get();
        
        return view('admin.user-profiles', compact('users'));
    }

    public function userDetail($id)
    {
        $user = User::with(['borrowings.copy.book'])->findOrFail($id);

        // --- Otomatik rezervasyon iptali ---
        Reservation::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('approval_date')
            ->where('approval_date', '<', Carbon::now()->subDays(3))
            ->update(['status' => 'expired']);

        // Kullanıcının aktif rezervasyonları (onaylanmış ve süresi geçmemiş)
        $activeReservations = Reservation::with(['bookCopy.book'])
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('approval_date')
            ->where('approval_date', '>=', Carbon::now()->subDays(3))
            ->get();

        return view('admin.user-detail', compact('user', 'activeReservations'));
    }

    public function userBorrowBook(Request $request, $userId)
    {
        $request->validate([
            'barcode' => 'required',
            'return_date' => 'required|date|after:today'
        ]);

        $copy = BookCopy::where('barcode', $request->barcode)
                       ->where('status', 'available')
                       ->firstOrFail();

        $borrowedBook = BorrowedBook::create([
            'user_id' => $userId,
            'copy_id' => $copy->id,
            'purchase_date' => now(),
            'return_date' => $request->return_date,
            'status' => 'borrowed'
        ]);

        $copy->status = 'borrowed';
        $copy->save();

        return redirect()->back()->with('success', 'Kitap başarıyla ödünç verildi.');
    }

    public function returnBook($id)
    {
        $borrow = BorrowedBook::findOrFail($id);
        $borrow->status = 'returned';
        $borrow->returned_at = now();
        $borrow->save();

        $borrow->copy->status = 'available';
        $borrow->copy->save();

        return redirect()->back()->with('success', 'Kitap başarıyla teslim alındı.');
    }

    public function extendDueDate(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:30'
        ]);

        $borrow = BorrowedBook::findOrFail($id);
        $borrow->return_date = $borrow->return_date->addDays(intval($request->days));
        $borrow->save();

        return redirect()->back()->with('success', 'Süre başarıyla uzatıldı.');
    }
}
