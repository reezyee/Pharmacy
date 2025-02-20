<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubchildKategori extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi
    protected $fillable = ['nama', 'parent_child_kategori_id'];

    // Relasi dengan ChildKategori
    public function childKategori()
    {
        return $this->belongsTo(ChildKategori::class, 'parent_child_kategori_id'); // Menyambungkan dengan ChildKategori
    }
}
