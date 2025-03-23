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
                    <a href="#" class="list-group-item list-group-item-action">Kitap Ekle</a>
                    <a href="#" class="list-group-item list-group-item-action">Kitapları Listele</a>
                    <a href="#" class="list-group-item list-group-item-action">Kategorileri Yönet</a>
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
                                <th>İşlem</th>
                                <th>Kullanıcı</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center">Henüz işlem bulunmuyor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection