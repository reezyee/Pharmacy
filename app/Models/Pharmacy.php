<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nomor_izin_apotek',
        'nama_apoteker',
        'sipa',
        'jadwal_praktik',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];
}