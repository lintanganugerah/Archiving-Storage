<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori', 'role', 'user', 'judul_aktivitas', 'aktivitas', 'perangkat', 'unit', 'recovery', 'recovery_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'name');
    }

    public function role()
    {
        return $this->belongsTo(User::class, 'role');
    }
}
