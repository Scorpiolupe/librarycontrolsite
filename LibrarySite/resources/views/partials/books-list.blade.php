<div class="row">
    @forelse($copies as $copy)
    <div class="col-12">
        <div class="card book-card">
            <a href="{{ url('/books/'.$copy->id) }}" class="book-link">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ $copy->book->book_name }}</h5>
                    <p class="card-text mb-2">{{ $copy->book->author->name }}</p>
                    <div class="book-details">
                        <p>
                            <strong>ISBN:</strong> {{ $copy->book->isbn }} | 
                            <strong>Kategori:</strong> {{ $copy->book->category->category_name }} | 
                            <strong>Sayfa:</strong> {{ $copy->book->page_count }} |  
                            <strong>Yayınevi:</strong> {{ $copy->book->publisher->name }} | 
                            <strong>Yayın Yılı:</strong> {{ $copy->book->publish_year }} | 
                            <strong>Raf:</strong> {{ $copy->shelf_location ?? 'Belirtilmemiş' }} | <br>
                            <strong>Durum:</strong>
                            @if($copy->status == 'available')
                                Müsait
                            @elseif($copy->status == 'borrowed')
                                Ödünç Alındı
                            @elseif($copy->status == 'reserved')
                                Rezerve Edildi
                            @else
                                {{ ucfirst($copy->status) }}
                            @endif
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center">Sonuç bulunamadı.</div>
    </div>
    @endforelse
</div>
@if(method_exists($copies, 'links'))
<div class="mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div class="page-info">
            <p>Toplam {{ $copies->total() }} kitap, {{ $copies->lastPage() }} sayfa</p>
        </div>
        <div class="pagination">
            {{ $copies->links() }}
        </div>
    </div>
</div>
@endif
