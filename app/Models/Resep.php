<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dokter_id',
        'pasien_id',
        'obats',
        'catatan',
        'status'
    ];

    protected $casts = [
        'obats' => 'array'
    ];

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'resep_obat')
            ->withPivot('dosis')
            ->withTimestamps();
    }
}
