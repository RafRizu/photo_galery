@extends('dashboard')
@section('content')
    <div class="p-2">
        <form action="{{ route('storeGaleri') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Galeri</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
            </div>
            <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
            <button type="submit" class="btn btn-primary text-dark">Unggah Foto</button>
        </form>
    </div>
@endsection
