<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'cif', 'agunan', 'ruang_agunan', 'lemari_agunan', 'rak_agunan', 'baris_agunan', 'Lokasi'
    ];
    
    public function cif()
    {
        return $this->belongsTo(Berkas::class, 'cif')->withDefault();
    }
    
    public function nama()
    {
        return $this->belongsTo(Berkas::class, 'nama')->withDefault();
    }
}
