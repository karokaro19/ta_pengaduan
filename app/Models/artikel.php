<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'judul_artikel',
        'isi_artikel',
        'users',
        'kategori',
        'gambar_artikel',
    ];		
	
    public function foreign_kategori()
    {
        // data model mitraa dimiliki oleh model user melalui fk 'id_mitra' belongsTo
        return $this->belongsTo(kategori_artikel::class, 'kategori');
    }   
}
