<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibadah extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_ibadah',
        'nama_ibadah',
        'quota'
    ];
}
