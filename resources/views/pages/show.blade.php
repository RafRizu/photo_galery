@extends('dashboard')
@section('content')
    <div class="container mt-5">
        @if ($album)
            <h2 class="fs-4 fw-bold">{{ $album->nama }}</h2>
            <p>{{ $album->deskripsi }}</p>
            <!-- Tampilkan foto-foto dalam album ini -->
            <div class="row">
                @forelse ($album->fotos as $foto)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="{{ asset('storage/' . $foto->path) }}" class="card-img-top" alt="{{ $foto->judul }}">
                            <div class="card-body">
                                <a href="{{ route('showFoto', $foto->slug) }}" class="card-title">{{ $foto->judul }}</a>
                                <p class="card-text">{{ $foto->deskripsi }}</p>
                                <small>{{ $foto->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Jika tidak ada foto, tampilkan pesan -->
                    <div class="col-md-12 text-center">
                        <p>Album ini belum memiliki foto.</p>
                    </div>
                @endforelse
            </div>
            <!-- Tambahkan tombol "Tambah Foto" -->

            @if ($iduser == $album->id_user)
                <div class="text-center mt-4">
                    <a href="{{ route('createFoto', ['id_album' => $album->id]) }}"
                        class="btn btn-primary text-dark mb-2 text-start">Tambah Foto</a>

                </div>
            @else
            @endif
            <br>
        @else
            <!-- Jika album tidak ditemukan -->
            <div class="col-md-12 text-center">
                <p>Album tidak ditemukan.</p>
            </div>
        @endif
    </div>



    </body>
@endsection
