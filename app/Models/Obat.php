<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';
    protected $fillable = [
        'nama',
        'nie',
        'kategori_id',
        'jenis_obat_id',
        'bentuk_obat_id',
        'deskripsi_obat',
        'dosis_obat',
        'kekuatan_obat',
        'komposisi_obat',
        'banyak',
        'harga',
        'foto',
        'tanggal_kedaluwarsa',
        'is_available'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class);
    }
    public function bentukObat()
    {
        return $this->belongsTo(BentukObat::class);
    }
    public function reseps()
    {
        return $this->belongsToMany(Resep::class, 'resep_obat')
            ->withPivot('dosis')
            ->withTimestamps();
    }
}
