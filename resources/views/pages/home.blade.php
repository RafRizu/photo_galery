@extends('dashboard')
@section('content')
    <div class="p-5">
        <div class="p-5">
            <h1 class="fs-3 fw-bold">Galeri Foto</h1>
        </div>
        <div class="card-columns row">
            @foreach ($photos as $album)
                <div class="card col-4 m-1">
                    @auth
                        <a href="/foto/{{ $album->slug }}">

                            <img src="{{ asset('storage/' . $album->path) }}" alt="{{ $album->judul }}">
                        </a>
                    @else
                        <a href="{{route('login')}}">

                            <img src="{{ asset('storage/' . $album->path) }}" alt="{{ $album->judul }}">
                        </a>

                    @endauth

                    <div class="card-body">
                        @auth
                        <a class="card-title fw-bold" href="/foto/{{ $album->slug }}">{{ $album->judul }}</a>
                        @else
                        <a class="card-title fw-bold" href="{{route('login')}}">{{ $album->judul }}</a>
                        @endauth
                        <p class="card-text">{{ $album->deskripsi }}</p>
                        <small>by : {{ $album->user->name }}</small><br>
                        <small>{{ $album->created_at->diffForHumans() }}</small><br>

                        @auth

                            <form action="{{ route('like.store', $album->slug) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_foto" value="{{ $album->id }}">
                                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">

                                @if ($album->isLikedByUser(Auth::user()->id))
                                    <button type="submit" class="btn btn-link text-danger">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-link text-danger">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                @endif
                                <span>{{ $album->likes->count() }}</span>
                            </form>
                        @else
                            <a type="submit" class="btn btn-link text-danger" href="{{ route('login') }}">
                                <i class="bi bi-heart"></i>
                            </a>

                        @endauth

                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
