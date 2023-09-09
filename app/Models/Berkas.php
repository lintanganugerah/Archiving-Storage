<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rek', 'nama', 'cif', 'agunan', 'jenis', 'lokasi', 'ruang', 'lemari', 'rak', 'baris', 'status',
    ];
    
    public function nama()
    {
        return $this->hasOne(Agunan::class, 'nama')->hasOne(Pinjam::class, 'nama')->hasOne(Pengembalians::class, 'nama');
    }
    public function cif()
    {
        return $this->hasOne(Agunan::class, 'cif')->hasOne(Pinjam::class, 'cif')->hasOne(Pengembalians::class, 'cif');
    }

    public function norek()
    {
        return $this->hasOne(Pinjam::class, 'no_rek')->hasOne(Pengembalians::class, 'no_rek');
    }
    public function jenis()
    {
        return $this->hasOne(Pinjam::class, 'jenis')->hasOne(Pengembalians::class, 'jenis');
    }
    public function lokasi()
    {
        return $this->hasOne(Pengembalians::class, 'lokasi');
    }
    public function lemari()
    {
        return $this->hasOne(Pinjam::class, 'lemari');
    }
    public function rak()
    {
        return $this->hasOne(Pinjam::class, 'rak');
    }
    public function baris()
    {
        return $this->hasOne(Pinjam::class, 'baris');
    }


    // ------------------------ //

    // public function norek1()
    // {
    //     return $this->hasOne(Pengembalian::class, 'no_rek');
    // }
    // public function jenis1()
    // {
    //     return $this->hasOne(Pengembalian::class, 'jenis');
    // }
    // public function lemari1()
    // {
    //     return $this->hasOne(Pengembalian::class, 'lemari');
    // }
    // public function rak1()
    // {
    //     return $this->hasOne(Pengembalian::class, 'rak');
    // }
    // public function baris1()
    // {
    //     return $this->hasOne(Pengembalian::class, 'baris');
}
