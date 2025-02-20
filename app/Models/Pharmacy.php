<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = [
        'name',
        'nomor_izin_apotek',
        'nama_apoteker',
        'sipa',
        'jadwal_praktik',
        'address',
        'latitude',
        'longitude',
        'is_active'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}