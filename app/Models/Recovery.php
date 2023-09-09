<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_rek', 'nama', 'cif', 'agunan', 'jenis', 'lokasi', 'ruang', 'lemari', 'rak', 'baris',  'berkas_id', 'ruang_agunan', 'lemari_agunan', 'rak_agunan', 'baris_agunan',
    ];

}
