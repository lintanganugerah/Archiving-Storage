<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rek', 'nama', 'cif', 'jenis', 'lokasi', 'status', 'user'
    ];

    public function norek()
    {
        return $this->belongsTo(Berkas::class, 'no_rek');
    }
    public function jenis()
    {
        return $this->belongsTo(Berkas::class, 'jenis');
    }
    public function nama()
    {
        return $this->belongsTo(Berkas::class, 'nama');
    }
    public function cif()
    {
        return $this->belongsTo(Berkas::class, 'cif');
    }
    public function lokasi()
    {
        return $this->belongsTo(Berkas::class, 'lokasi');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'name');
    }
}
