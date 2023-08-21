<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rek', 'nama', 'cif', 'agunan', 'jenis', 'lokasi', 'ruang', 'lemari', 'rak', 'baris', 'status', 'user', 'catatan'
    ];

    public function norek()
    {
        return $this->belongsTo(Berkas::class, 'no_rek');
    }
    public function jenis()
    {
        return $this->belongsTo(Berkas::class, 'jenis');
    }
    public function lemari()
    {
        return $this->belongsTo(Berkas::class, 'lemari');
    }
    public function rak()
    {
        return $this->belongsTo(Berkas::class, 'rak');
    }
    public function baris()
    {
        return $this->belongsTo(Berkas::class, 'baris');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'name');
    }
}
