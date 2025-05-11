@extends('layout')

@section('title', 'Kullanıcı Detayı')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">{{ $user->name }}</h3>
                        <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-primary' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'Üye' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img src="{{ asset('avatars/' . ($user->avatar ?? 'default-avatar.png')) }}" 
                                 class="rounded-circle mb-3" 
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Kişisel Bilgiler</h5>
                                    <p><strong>TC Kimlik No:</strong> {{ $user->tcno }}</p>
                                    <p><strong>E-posta:</strong> {{ $user->email }}</p>
                                    <p><strong>Telefon:</strong> {{ $user->tel }}</p>
                                    <p><strong>Kayıt Tarihi:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h5>Özet Bilgiler</h5>
                                    <p><strong>Toplam Ödünç Alma:</strong> {{ $user->borrowings->count() }}</p>
                                    <p><strong>Aktif Ödünç:</strong> {{ $user->borrowings->where('status', 'borrowed')->count() }}</p>
                                    <p><strong>Gecikmiş Teslim:</strong> {{ $user->borrowings->where('status', 'overdue')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktif Ödünç Alınan Kitaplar -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Aktif Ödünç Alınan Kitaplar</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#borrowBookModal">
                            <i class="bi bi-plus-lg"></i> Kitap Ödünç Ver
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kitap</th>
                                    <th>Alış Tarihi</th>
                                    <th>Son Teslim</th>
                                    <th>Durum</th>
                                    <th>Kalan Gün</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->borrowings->where('status', 'borrowed') as $borrow)
                                <tr>
                                    <td>{{ $borrow->copy->book->book_name }}</td>
                                    <td>{{ $borrow->purchase_date->format('d/m/Y') }}</td>
                                    <td>{{ $borrow->return_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $borrow->status_color }}">
                                            {{ $borrow->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $borrow->days_remaining < 0 ? 'bg-danger bg-opacity-25' : 'bg-secondary' }}">
                                            {{ (int)$borrow->days_remaining }} gün
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.returnBook', $borrow->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Kitabı teslim almak istediğinize emin misiniz?')">
                                                    <i class="bi bi-check-lg"></i> Teslim Al
                                                </button>
                                            </form>

                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#extendModal{{ $borrow->id }}">
                                                <i class="bi bi-calendar-plus"></i> Süre Uzat
                                            </button>
                                        </div>

                                        <!-- Süre Uzatma Modalı -->
                                        <div class="modal fade" id="extendModal{{ $borrow->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.extendDueDate', $borrow->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Süre Uzat</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kaç Gün Uzatılacak?</label>
                                                                <input type="number" name="days" class="form-control" 
                                                                       value="7" min="1" max="30" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" 
                                                                    data-bs-dismiss="modal">İptal</button>
                                                            <button type="submit" class="btn btn-primary">Uzat</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aktif ödünç alınan kitap bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rezerve Edilmiş Kitaplar -->
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Rezerve Edilmiş Kitaplar</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($activeReservations) && $activeReservations->count())
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Kitap</th>
                                            <th>Barkod</th>
                                            <th>Rezervasyon Onay Tarihi</th>
                                            <th>Kalan Gün</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeReservations as $reservation)
                                            <tr>
                                                <td>{{ $reservation->bookCopy->book->book_name }}</td>
                                                <td>{{ $reservation->bookCopy->barcode }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservation->approval_date)->format('d.m.Y H:i') }}</td>
                                                <td>
                                                    @php
                                                        $daysLeft = $reservation->days_left;
                                                    @endphp
                                                    @if($daysLeft >= 0)
                                                        <span class="badge bg-info">{{ (int)$daysLeft }} gün</span>
                                                    @else
                                                        <span class="badge bg-danger">Süre doldu</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="alert alert-warning mt-2">
                                    <strong>Not:</strong> Rezerve edilen kitaplar 3 gün içinde teslim alınmazsa rezervasyon otomatik olarak iptal edilir.
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                Aktif rezerve edilmiş kitap bulunmamaktadır.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Geçmiş Ödünç Kayıtları -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Ödünç Alma Geçmişi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kitap</th>
                                    <th>Alış Tarihi</th>
                                    <th>Teslim Tarihi</th>
                                    <th>Durum</th>
                                    <th>Gecikme Durumu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->borrowings->where('status', 'returned') as $borrow)
                                <tr>
                                    <td>{{ $borrow->copy->book->book_name }}</td>
                                    <td>{{ $borrow->purchase_date->format('d/m/Y') }}</td>
                                    <td>{{ $borrow->returned_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $borrow->status_color }}">
                                            {{ $borrow->status_text }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($borrow->delay_day > 0)
                                            <span class="text-danger">{{ $borrow->delay_day }} gün gecikme</span>
                                        @else
                                            <span class="text-success">Zamanında teslim</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Geçmiş ödünç kayıtları bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal ekliyoruz (sayfanın sonuna) -->
<div class="modal fade" id="borrowBookModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kitap Ödünç Ver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.userBorrowBook', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Kitap Barkod No</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" required>
                    </div>
                    <div class="mb-3">
                        <label for="return_date" class="form-label">İade Tarihi</label>
                        <input type="date" class="form-control" id="return_date" name="return_date" 
                               value="{{ date('Y-m-d', strtotime('+14 days')) }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Ödünç Ver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
function returnBook(borrowId) {
    if(confirm('Kitabı teslim almak istediğinize emin misiniz?')) {
        fetch('/adminpanel/borrowed-books/' + borrowId + '/return', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        });
    }
}

function extendDueDate(borrowId) {
    const days = prompt('Kaç gün uzatmak istiyorsunuz?', '7');
    if(days) {
        fetch('/adminpanel/borrowed-books/' + borrowId + '/extend', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ days: parseInt(days) })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Bir hata oluştu!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        });
    }
}
</script>
@endpush
