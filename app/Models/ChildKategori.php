<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildKategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'parent_kategori_id'];

    public function parent()
    {
        return $this->belongsTo(Kategori::class, 'parent_kategori_id');
    }

    public function subchildren()
    {
        return $this->hasMany(SubchildKategori::class, 'parent_child_kategori_id');
    }
}
