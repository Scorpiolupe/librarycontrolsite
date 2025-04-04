@extends('layout')

@section('title', 'Kitap Listesi')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h2>Kitap Listesi</h2>
            <a href="{{ url('/adminpanel/create-book') }}" class="btn btn-primary">Yeni Kitap Ekle</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kitap Adı</th>
                            <th>Yazar</th>
                            <th>Kategori</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->book_name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>
                                <span class="badge {{ $book->status == 'available' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $book->status == 'available' ? 'Mevcut' : 'Ödünç Verildi' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/adminpanel/books/'.$book->id) }}" class="btn btn-info btn-sm" title="Detay">
                                        <i class="bi bi-eye"></i> Detay
                                    </a>
                                    <a href="{{ url('/adminpanel/books/'.$book->id.'/edit') }}" class="btn btn-warning btn-sm" title="Düzenle">
                                        <i class="bi bi-pencil"></i> Düzenle
                                    </a>
                                    <button type="button" class="btn btn-success btn-sm status-change" data-id="{{ $book->id }}" title="Durum Değiştir">
                                        <i class="bi bi-arrow-repeat"></i> Durum
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-book" data-id="{{ $book->id }}" title="Sil">
                                        <i class="bi bi-trash"></i> Sil
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Henüz kitap eklenmemiş</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Silme işlemi için
    const deleteButtons = document.querySelectorAll('.delete-book');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            if(confirm('Bu kitabı silmek istediğinizden emin misiniz?')) {
                // Silme işlemi için AJAX çağrısı yapılacak
            }
        });
    });

    // Durum değiştirme işlemi için
    const statusButtons = document.querySelectorAll('.status-change');
    statusButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Durum değiştirme işlemi için AJAX çağrısı yapılacak
        });
    });
});
</script>
@endsection