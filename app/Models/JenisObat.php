<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisObat extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'jenis_obat';

    // The attributes that are mass assignable.
    protected $fillable = [
        'nama_jenis_obat',
        'deskripsi_jenis_obat',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [];

    // The attributes that should be cast to native types.
    protected $casts = [];

    /**
     * Get the medicines that belong to this type.
     */
    public function obat()
    {
        return $this->hasMany(Obat::class, 'jenisObat_id');
    }
}
