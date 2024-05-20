<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengaduan extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'judul_pengaduan',
        'jenis_pengaduan',
        'isi_pengaduan',
        'file_pendukung',
        'id_pengirim ',
        'respon ',
        'status_pengaduan',
    ];		
	
    public function foreign_pengirim()
    {
        // data model mitraa dimiliki oleh model user melalui fk 'id_mitra' belongsTo
        return $this->belongsTo(pengirim::class, 'id_pengirim');
    }   	
	
}
