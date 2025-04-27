@extends('layout')

@section('title', 'Ödünç İşlemlerini Yönet')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Ödünç İşlemleri</h2>
        <div class="mb-4">
            <a href="{{ route('admin.borrowRequests') }}" class="btn btn-primary">
                Bekleyen İstekler
                @if($pendingCount > 0)
                    <span class="badge bg-light text-dark">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>İşlem ID</th>
                        <th>Kullanıcı</th>
                        <th>Kitap</th>
                        <th>Kopya Barkodu</th>
                        <th>Ödünç Tarihi</th>
                        <th>Son Teslim</th>
                        <th>Durum</th>
                        <th>İşlemler</th>  
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowedBooks as $borrow)
                    <tr>
                        <td>{{ $borrow->id }}</td>
                        <td>{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->bookCopy->book->book_name }}</td>
                        <td>{{ $borrow->bookCopy->barcode }}</td>
                        <td>{{ $borrow->created_at->format('d/m/Y') }}</td>
                        <td>{{ $borrow->return_date->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $status = 'Ödünç Verildi';
                                $class = 'success';
                                if($borrow->return_date < now()) {
                                    $status = 'Gecikmiş';
                                    $class = 'danger';
                                }
                            @endphp
                            <span class="badge bg-{{ $class }}">{{ $status }}</span>
                        </td>
                        <td>
                            @if($borrow->return_date < now())
                            <button class="btn btn-warning btn-sm send-reminder" 
                                    data-id="{{ $borrow->id }}">
                                Hatırlat
                            </button>
                            @endif
                            <button class="btn btn-info btn-sm view-details" 
                                    data-id="{{ $borrow->id }}">
                                Detay
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Ödünç verilen kitap bulunmamaktadır.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $borrowedBooks->links() }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendReminders = document.querySelectorAll('.send-reminder');
    sendReminders.forEach(button => {
        button.addEventListener('click', function() {
            const borrowId = this.dataset.id;
            // Hatırlatma gönderme işlemi
            fetch(`/admin/borrows/${borrowId}/remind`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('Hatırlatma başarıyla gönderildi');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu');
            });
        });
    });
});
</script>
@endsection
