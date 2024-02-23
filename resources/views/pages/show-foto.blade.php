@extends('dashboard')
@section('content')
    <div class="p-3">
        <h1>{{ $foto->judul }}</h1>
        <p>{{ $foto->deskripsi }}</p>
        <small>{{ $foto->created_at->diffForHumans() }}</small>
        <img src="{{ asset('storage/' . $foto->path) }}" alt="{{ $foto->judul }}">
        <br>
        <form action="{{ route('like.store', $foto->slug) }}" method="POST">
            @csrf
            <input type="hidden" name="id_foto" value="{{ $foto->id }}">
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">

            @if ($foto->isLikedByUser(Auth::user()->id))
                <button type="submit" class="btn btn-link text-danger">
                    <i class="bi bi-heart-fill"></i>
                </button>
            @else
                <button type="submit" class="btn btn-link text-danger">
                    <i class="bi bi-heart"></i>
                </button>
            @endif
            <span>{{ $clike }}</span>
        </form>

        <br>
        <form action="{{ route('comment.store', $foto->slug) }}" method="POST">
            @csrf
            <input type="hidden" name="id_foto" value="{{ $foto->id }}">
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
            <div class="form-group">
                <label for="isi">Komentar:</label>
                <textarea class="form-control" id="isi" name="isi" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary text-dark mt-1">Kirim</button>
        </form>
        <br>
        @if ($foto->id_user == $iduser)
            <div class="text-start mt-4">
                <form action="{{route('deleteFoto',$foto->slug)}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit"
                        class="btn btn-danger text-dark mb-2 text-start" value="Hapus Foto"></input>
                </form>

            </div>
        @else
        @endif
        <br>
        <div class="comments">
            <h3>Komentar</h3>
            @forelse ($comments as $comment)
                <div class="comment">
                    <p class="text-dark"><strong>{{ $comment->user->name }}</strong>: {{ $comment->isi }}</p>
                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p>Belum ada komentar untuk foto ini.</p>
            @endforelse
        </div>
    </div>
@endsection
