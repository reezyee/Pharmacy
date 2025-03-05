<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resep extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'reseps'; // Pastikan ini ada

    protected $fillable = ['pasien_id', 'tipe', 'dokter_id', 'obats', 'foto_resep', 'catatan', 'status', 'pasien_nama'];
    protected $casts = ['obats' => 'array', 'foto_resep' => 'array'];

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
        return $this->belongsToMany(Obat::class, 'obat_reseps', 'resep_id', 'obat_id')
            ->withPivot('dosis');
    }

    public function obatReseps()
    {
        return $this->hasMany(ObatResep::class, 'resep_id');
    }
}
