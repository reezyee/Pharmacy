<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ObatResep extends Pivot
{
    protected $table = 'obat_reseps';

    protected $fillable = [
        'resep_id',
        'obat_id',
        'dosis',
    ];
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
