@section('title', 'Profilim')

@section('content')
<div class="container">
    <div class="row">
<<<<<<< HEAD
        <!-- Sol Kolon - Profil Bilgileri -->
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">


=======
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <div class="card-header text-center">
                    <h4>Profilim</h4>
                </div>
>>>>>>> parent of d487398 (updated profile & book covers)
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block">
                        <img src="{{ asset('avatars/' . ($user->avatar ?? 'default-avatar.png')) }}" class="rounded-circle mb-3" alt="Profil Resmi" width="150" height="150">
                        <label for="avatar" class="position-absolute bottom-0 end-0 translate-middle p-2 bg-primary rounded-circle" style="cursor: pointer;">
                            <i class="bi bi-pencil text-white"></i>
                        </label>
                    </div>

@@ -21,26 +23,193 @@
                        @csrf
                        <input type="file" class="form-control" name="avatar" id="avatar" required onchange="this.form.submit()">
                    </form>
                    @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <p><strong>Ad Soyad:</strong> {{ $user->name }}</p>
                    <p><strong>E-posta:</strong> {{ $user->email }}</p>
                    <p><strong>Telefon:</strong> {{ $user->tel }}</p>
                    <p><strong>Rol:</strong> {{ $user->rol ?? 'N/A' }}</p>
                    <p><strong>Favori Kitap:</strong> {{ $user->favori_kitap ?? 'N/A' }}</p>
                    <p><strong>Favori Kategori:</strong> {{ $user->favori_kategori ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
@endsection
=======
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
@endpush
>>>>>>> parent of d487398 (updated profile & book covers)
