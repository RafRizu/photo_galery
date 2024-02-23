@extends('dashboard')
@section('content')
    <div class="p-5">
        <div class="p-5">

            <h1>Galeri Foto Mu</h1>
        </div>
        <div class="card-columns">
            @foreach ($album as $photo)
                <div class="card">
                    <img class="card-img-top" src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->judul }}">
                    <div class="card-body">
                        <a class="card-title" href="/album/{{ $photo->slug }}">{{ $photo->nama }}</a>
                        <p class="card-text">{{ $photo->deskripsi }}</p>
                        <form action="{{ route('deleteGaleri', $photo->slug) }}" method="post">
                            @csrf
                            @method('delete')
                            <input class="btn btn-danger text-dark" type="submit" value="Hapus"></input>
                        </form>
                    </div>
                </div>
                <br>
            @endforeach
        </div>

    </div>
@endsection
