<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori_artikel extends Model
{
    use HasFactory;
	
    protected $fillable = [
        'nama_kategori',
        'hastag_kategori',
    ];	
}
