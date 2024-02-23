@extends('dashboard')
@section('content')
    <div class="p-5">
        <div class="p-5">
            <h1 class="fs-3 fw-bold">Galeri Foto</h1>
        </div>
        <div class="card-columns">
            @foreach ($photos as $album)
                {{-- @php
                    $foto = $fotos[$album->id] ?? null; // Retrieving the photo associated with the current album
                @endphp --}}
                <div class="card">
                    @if ($foto)
                        <img src="{{ asset('storage/' . $foto->path) }}" alt="{{ $foto->judul }}">
                    @endif
                    <div class="card-body">
                        <a class="card-title" href="/album/{{ $album->slug }}">{{ $album->nama }}</a>
                        <p class="card-text">{{ $album->deskripsi }}</p>
                        <small>by : {{ $album->user->name }}</small>
                        <small>{{ $album->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
