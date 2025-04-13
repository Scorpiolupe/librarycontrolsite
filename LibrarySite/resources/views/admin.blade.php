@extends('layout')

@section('title', 'Admin Panel')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2>Yönetim Paneli</h2>
        <hr>
    </div>

    <!-- İstatistikler -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Toplam Kitap</h5>
                <h2 class="card-text">0</h2>
                <small>Kütüphanedeki kitap sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Aktif Üyeler</h5>
                <h2 class="card-text">0</h2>
                <small>Kayıtlı kullanıcı sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Ödünç Kitaplar</h5>
                <h2 class="card-text">0</h2>
                <small>Ödünç verilen kitap sayısı</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Kategoriler</h5>
                <h2 class="card-text">0</h2>
                <small>Toplam kategori sayısı</small>
            </div>
        </div>
    </div>

    <!-- Yönetim Kartları -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kitap Yönetimi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    
                    <a href="/adminpanel/list-books" class="list-group-item list-group-item-action">Kitapları Yönet</a>
                    <a href="/adminpanel/manage-copies" class="list-group-item list-group-item-action">Kitap Kopyalarını Yönet</a>
                    <a href="/adminpanel/manage-categories" class="list-group-item list-group-item-action">Kategorileri Yönet</a>
                    <a href="/adminpanel/manage-authors" class="list-group-item list-group-item-action">Yazarları Yönet</a>
                    <a href="/adminpanel/manage-publishers" class="list-group-item list-group-item-action">Yayınevlerini Yönet</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Üye Yönetimi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">Üye Ekle</a>
                    <a href="#" class="list-group-item list-group-item-action">Üyeleri Listele</a>
                    <a href="#" class="list-group-item list-group-item-action">Üye Rolleri</a>
                    <a href="/adminpanel/manage-fines" class="list-group-item list-group-item-action">Cezaları Yönet</a>
                    <a href="/adminpanel/manage-reviews" class="list-group-item list-group-item-action">Yorumları Yönet</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Stok Yönetimi</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="/adminpanel/manage-stocks" class="list-group-item list-group-item-action">Stokları Yönet</a>
                    <a href="/adminpanel/manage-borrowings" class="list-group-item list-group-item-action">Ödünç İşlemleri</a>
                    <a href="/adminpanel/manage-returns" class="list-group-item list-group-item-action">İade İşlemleri</a>
                    <a href="/adminpanel/manage-reservations" class="list-group-item list-group-item-action">Rezervasyon İşlemleri</a>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Son İşlemler Tablosu -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Son İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>İşlem ID</th>
                                <th>İşlem Türü</th>
                                <th>İşlem Detayı</th>
                                <th>Kullanıcı</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($activities->count() > 0)
                                @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->activity_type }}</td>
                                    <td>{{ $activity->activity_description }}</td>
                                    <td>{{ $activity->user ? $activity->user->name : 'Silinmiş Kullanıcı' }}</td>
                                    <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Henüz işlem bulunmuyor</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection