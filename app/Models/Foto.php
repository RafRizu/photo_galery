<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Album;
use App\Models\Komen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';
     protected $fillable = ['judul','slug', 'deskripsi','path','id_album', 'id_user'];

        public function album()
    {
        return $this->belongsTo(Album::class, 'id_album');
    }
        public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
public function likes()
{
    return $this->hasMany(Like::class, 'id_foto');
}
public function komen()
{
    return $this->hasMany(Komen::class, 'id');
}

    // Memeriksa apakah pengguna sudah menyukai foto ini
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('id_user', $userId)->exists();
    }

    // Memeriksa apakah foto ini sudah disukai oleh pengguna yang sedang login
    public function isLikedByLoggedInUser()
    {
        $loggedInUserId = Auth::user()->id;
        if ($loggedInUserId) {
            return $this->isLikedByUser($loggedInUserId);
        }
        return false;
    }
}
