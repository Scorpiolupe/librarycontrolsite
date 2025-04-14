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
                <label for="shelf_location" class="form-label">Raf Konumu</label>
                <input type="text" class="form-control" id="shelf_location" name="shelf_location" placeholder="Raf konumunu girin">
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
