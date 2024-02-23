<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{

    protected $table = 'komens';

    protected $fillable = ['id_user', 'id_foto', 'isi'];

    // Jika nama kolom dalam tabel basis data berbeda
    protected $primaryKey = 'id'; // default primary key dalam tabel komens
    protected $foreignKeyUser = 'id_user'; // nama kolom untuk foreign key user
    protected $foreignKeyFoto = 'id_foto'; // nama kolom untuk foreign key foto

    public function foto()
    {
        return $this->belongsTo(Foto::class, $this->foreignKeyFoto);
    }

    public function user()
    {
        return $this->belongsTo(User::class, $this->foreignKeyUser);
    }
}
