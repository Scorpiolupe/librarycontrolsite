@extends('layout')

@section('title', 'Kategori Listesi')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#newCategoryCard" aria-expanded="false" aria-controls="newCategoryCard">
                        <i class="bi bi-plus-circle"></i> Yeni Kategori Ekle
                    </button>
                </div>
                <div class="collapse" id="newCategoryCard">
                    <div class="card-body">
                        <form action="{{ route('admin.createCategory') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Kategori Adı</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Kategori Ekle
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori Adı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/adminpanel/categories/'.$category->id.'/edit') }}" class="btn btn-warning btn-sm" title="Düzenle">
                                        <i class="bi bi-pencil"></i> Düzenle
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm delete-category" data-id="{{ $category->id }}" title="Sil">
                                        <i class="bi bi-trash"></i> Sil
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Henüz kategori eklenmemiş</td>
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
    const deleteButtons = document.querySelectorAll('.delete-category');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.dataset.id;
            if(confirm('Bu kategoriyi silmek istediğinizden emin misiniz? Bu işlem kategoriye ait kitapları etkileyebilir.')) {
                // AJAX silme işlemi
                fetch(`/adminpanel/categories/${categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        alert('Kategori silinirken bir hata oluştu!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Bir hata oluştu!');
                });
            }
        });
    });
});
</script>
@endsection