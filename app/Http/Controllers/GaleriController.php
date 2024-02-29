<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Komen;
use App\Models\Like;
use App\Models\Album;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleriController extends Controller
{
    //
public function index()
{
    $photos = Foto::with('user')->with('likes')->with('komen')->latest()->get();

    // $fotos = [];
    // $foto = null; // Define $foto variable here

    // foreach ($photos as $album) {
    //     $foto = Foto::where('id_album', $album->id)->first();
    //     // You might want to handle the case where $foto is null if there's no photo for an album
    //     $fotos[$album->id] = $foto;
    // }

    return view('pages.home', compact('photos'));
}


        public function yourGaleri()
    {
        $album= Album::where('id_user', Auth::user()->id)->get();
        return view('pages.album', compact('album'));
    }
public function showGaleri($slug)
{
    // Dapatkan album berdasarkan slug
    $album = Album::where('slug', $slug)->with('fotos')->first();
    // dd($album);
    $iduser = Auth::user()->id;
    // dd($iduser);
    // Simpan id_album di sesi


    // Tampilkan halaman detail album
    return view('pages.show', compact('album','iduser'));
}
public function deleteGaleri($slug)
{

    // Dapatkan album berdasarkan slug
  Album::where('slug', $slug)->where('id_user',Auth::user()->id)->delete();

    // Simpan id_album di sesi


    // Tampilkan halaman detail album
    return redirect()->route('yourGaleri')->with('success', 'Album berhasil dihapus!');
}
public function deleteFoto($slug)
{

    // Dapatkan album berdasarkan slug
  Foto::where('slug', $slug)->where('id_user',Auth::user()->id)->delete();

    // Simpan id_album di sesi


    // Tampilkan halaman detail album
    return redirect()->route('yourGaleri')->with('success', 'Foto berhasil dihapus!');
}



        public function showFoto($slug)
    {
        $foto = Foto::where('slug', $slug)->first();
        $comments = Komen::where('id_foto', $foto->id)->get();
        $clike = Like::where('id_foto',$foto->id)->count();
            $iduser = Auth::user()->id;
        return view('pages.show-foto', compact('foto','comments','clike','iduser'));
    }
    public function createGaleri()
    {
        return view('pages.create-galeri');
    }
    // public function createFoto($id_album)
    // {
    //     return view('pages.create-foto', compact('id_album'));
    // }

    public function storeGaleri(Request $request)
    {
        // Validasi data yang dikirim oleh pengguna
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',

        ]);

        // Simpan foto ke penyimpanan yang sesuai (contoh: /storage/app/public)
        // $gambarPath = $request->file('gambar')->store('photos', 'public');

        // Simpan detail foto ke database
Album::create([
    'nama' => $request->nama,
    'deskripsi' => $request->deskripsi,
    'slug' => str_replace(' ', '-', $request->nama),
    'id_user' => $request->id_user,
]);

        return redirect()->route('dashboard')->with('success', 'Album berhasil diunggah!');
    }


public function createFoto($id_album)
{
    // Dapatkan album berdasarkan id_album yang diteruskan
    $album = Album::findOrFail($id_album);

    // Kemudian, Anda dapat mengirimkan album ke tampilan tambah foto
    return view('pages.create-foto', compact('album','id_album'));
}


public function storeFoto(Request $request)
{
    // Validasi data yang dikirim oleh pengguna
    $request->validate([
        'judul' => 'required',
        'deskripsi' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Simpan gambar ke penyimpanan yang sesuai (contoh: /storage/app/public)
    $gambarPath = $request->file('gambar')->store('photos', 'public');

    // Simpan detail foto ke database menggunakan metode create
    Foto::create([
        'judul' => $request->judul,
        'slug' => str_replace(' ', '-', $request->judul),
        'deskripsi' => $request->deskripsi,
        'path' => $gambarPath,
        'id_album' => $request->id_album,
        'id_user' => Auth::user()->id,
    ]);

    // Dapatkan slug album yang akan dialihkan


    // Hapus slug album dari sesi karena sudah tidak diperlukan


    // Redirect ke halaman album yang sebelumnya dibuka
    return redirect()->route('yourGaleri')->with('success', 'Foto berhasil diunggah!');
}








    //like

   public function like(Request $request, $slug)
{
    // Pastikan pengguna telah login
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Anda harus login untuk melakukan like.');
    }

    // Ambil foto berdasarkan slug
    $foto = Foto::where('slug', $slug)->first();

    // Jika foto tidak ditemukan
    if (!$foto) {
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }

    // Cek apakah pengguna sudah menyukai foto ini sebelumnya
    $existingLike = Like::where('id_foto', $request->id_foto)
                        ->where('id_user', $request->id_user)
                        ->first();

    // Jika pengguna sudah menyukai foto ini sebelumnya
    if ($existingLike) {
        // Hapus like yang sudah ada
        $existingLike->delete();
        return redirect()->back()->with('success', 'Anda telah tidak menyukai foto ini lagi.');
    }

    // Tambahkan like baru
Like::create([
    'id_foto' => $request->id_foto,
    'id_user' => $request->id_user,
]);

    return redirect()->back()->with('success', 'Anda telah menyukai foto ini.');
}



//komentar

public function storeComment(Request $request, $slug)
{
    // Pastikan pengguna telah login
    if (!Auth::check()) {
        return redirect()->back()->with('error', 'Anda harus login untuk melakukan Komentar.');
    }

    // Ambil foto berdasarkan slug
    $foto = Foto::where('slug', $slug)->first();

    // Jika foto tidak ditemukan
    if (!$foto) {
        return redirect()->back()->with('error', 'Foto tidak ditemukan.');
    }

    // Validasi data input jika diperlukan
    $request->validate([
        'isi' => 'required|string|max:255',
    ]);

    // Simpan komentar menggunakan metode create
    Komen::create([
        'id_foto' => $foto->id,
        'id_user' => Auth::id(), // Ambil id pengguna yang sedang login
        'isi' => $request->isi,
    ]);

    // Redirect kembali ke halaman foto atau sesuai kebutuhan Anda
    return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
}
}
