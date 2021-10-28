<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'nama_jemaat',
        'umur',
        'nik',
        'id_ibadah',
        'date_registered',
        'wilayah',
        'kelompok',
        'gereja_asal',
        'isScanned'
    ];
}
