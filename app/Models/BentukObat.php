<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentukObat extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'bentuk_obat';

    // The attributes that are mass assignable.
    protected $fillable = [
        'nama_bentuk_obat',
        'deskripsi_bentuk_obat',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [];

    // The attributes that should be cast to native types.
    protected $casts = [];

    /**
     * Get the medicines that belong to this form.
     */
    public function obat()
    {
        return $this->hasMany(Obat::class, 'bentukObat_id');
    }
}
