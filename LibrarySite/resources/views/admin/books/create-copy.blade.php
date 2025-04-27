@extends('layout')

@section('title', 'Yeni Kitap Kopyası Ekle')

@section('content')
<div class="container">
    <h2 class="mb-4">Yeni Kitap Kopyası Ekle</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.storeCopy') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="book_id" class="form-label">Kitap</label>
                <select class="form-select" id="book_id" name="book_id" required>
                    <option value="">Kitap Seçin</option>
                    @foreach($books as $book)
                        <option value="{{ $book->book_name }}">{{ $book->book_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <select class="form-select" id="isbn" name="isbn" required>
                    <option value="">Önce kitap seçin</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="publisher" class="form-label">Yayınevi</label>
                <input type="text" class="form-control" id="publisher" name="publisher" readonly>
            </div>

            

            <div class="col-md-6 mb-3">
                <label for="acquisition_date" class="form-label">Edinme Tarihi</label>
                <input type="date" class="form-control" id="acquisition_date" name="acquisition_date">
            </div>

            <div class="col-md-6 mb-3">
                <label for="acquisition_source" class="form-label">Edinme Türü</label>
                <select class="form-select" id="acquisition_source" name="acquisition_source" required>
                    <option value="Satın Alım">Satın Alım</option>
                    <option value="Bağış">Bağış</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="acquisition_cost" class="form-label">Edinme Maliyeti (₺)</label>
                <input value="0" type="number" class="form-control" id="acquisition_cost" name="acquisition_cost" placeholder="Maliyeti girin" step="0.01">
            </div>  

            <div class="col-md-6 mb-3">
                <label for="condition" class="form-label">Yıpranma Durumu</label>
                <select class="form-select" id="condition" name="condition" required>
                    <option value="yıpranmamış">Yıpranmamış</option>
                    <option value="az yıpranmış">Az Yıpranmış</option>
                    <option value="yıpranmış">Yıpranmış</option>
                    <option value="çok yıpranmış">Çok Yıpranmış</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Durum</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available">Mevcut</option>
                    <option value="borrowed">Ödünç Verildi</option>
                    <option value="reserved">Rezerve</option>
                    <option value="lost">Kayıp</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Yer Bilgisi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="block" class="form-label">Blok</label>
                                <select class="form-select" id="block" name="block" required>
                                    <option value="">Blok Seçin</option>
                                    <option value="A">A Blok</option>
                                    <option value="B">B Blok</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="floor" class="form-label">Kat</label>
                                <select class="form-select" id="floor" name="floor" required>
                                    <option value="">Kat Seçin</option>
                                    <option value="0">Zemin Kat</option>
                                    <option value="1">1. Kat</option>
                                    <option value="2">2. Kat</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="row" class="form-label">Sıra No</label>
                                <select class="form-select" id="row" name="row" required>
                                    <option value="">Sıra Seçin</option>
                                    @for($i = 1; $i <= 21; $i++)
                                        <option value="{{ $i }}">{{ $i }}. Sıra</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="shelf" class="form-label">Raf No</label>
                                <select class="form-select" id="shelf" name="shelf" required>
                                    <option value="">Raf Seçin</option>
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}">{{ $i }}. Raf</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="position" class="form-label">Pozisyon</label>
                                <input type="number" class="form-control" id="position" name="position" 
                                       min="1" max="150" required 
                                       oninput="this.value = this.value > 150 ? 150 : Math.abs(this.value)">
                                <small class="form-text text-muted">1-150 arası bir değer girin</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="selected_book_id" name="book_id">

        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookSelect = document.getElementById('book_id');
    const isbnSelect = document.getElementById('isbn');
    const publisherInput = document.getElementById('publisher');
    const selectedBookIdInput = document.getElementById('selected_book_id');

    bookSelect.addEventListener('change', function() {
        const bookName = this.value;
        isbnSelect.innerHTML = '<option value="">ISBN yükleniyor...</option>';
        publisherInput.value = '';
        selectedBookIdInput.value = '';

        if (bookName) {
            fetch(`/adminpanel/books/${encodeURIComponent(bookName)}/isbns`)
                .then(response => response.json())
                .then(data => {
                    isbnSelect.innerHTML = '<option value="">ISBN Seçin</option>';
                    if (!data.error && data.books.length > 0) {
                        data.books.forEach(book => {
                            const option = document.createElement('option');
                            option.value = book.isbn;
                            option.textContent = book.isbn;
                            option.dataset.id = book.id;
                            option.dataset.publisher = book.publisher;
                            isbnSelect.appendChild(option);
                        });
                    } else {
                        isbnSelect.innerHTML = '<option value="">ISBN bulunamadı</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    isbnSelect.innerHTML = '<option value="">Bir hata oluştu</option>';
                });
        } else {
            isbnSelect.innerHTML = '<option value="">Önce kitap seçin</option>';
        }
    });

    isbnSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.id) {
            selectedBookIdInput.value = selectedOption.dataset.id;
            publisherInput.value = selectedOption.dataset.publisher;
        } else {
            selectedBookIdInput.value = '';
            publisherInput.value = '';
        }
    });
});

</script>
@endsection
