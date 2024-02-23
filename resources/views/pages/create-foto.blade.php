@extends('dashboard')
@section('content')
    <div class="p-4">

        <form action="{{ route('storeFoto') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id_album" value="{{ $id_album }}">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div><br>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
            </div><br>
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar" required>
            </div><br>
            <button type="submit" class="btn btn-primary text-dark">Unggah Foto</button>
        </form>
    </div>
@endsection
