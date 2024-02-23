<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $fillable = ['nama', 'deskripsi','slug', 'id_user'];
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_album');
    }
public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
        public function showGallery()
    {
        // Mendapatkan semua foto dari album ini
        $fotos = $this->fotos;

        // Memanggil view 'albums.gallery' dan melewatkan data foto
        return view('albums.gallery', compact('fotos'));
    }

}
