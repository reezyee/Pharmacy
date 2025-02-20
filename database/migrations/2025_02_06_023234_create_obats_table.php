<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nie');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
            $table->foreignId('jenis_obat_id')->nullable()->constrained('jenis_obat')->onDelete('set null');
            $table->foreignId('bentuk_obat_id')->nullable()->constrained('bentuk_obat')->onDelete('set null');
            $table->text('deskripsi_obat');
            $table->string('dosis_obat');
            $table->string('kekuatan_obat');
            $table->string('komposisi_obat');
            $table->integer('banyak');
            $table->integer('harga');
            $table->string('foto')->nullable();
            $table->date('tanggal_kedaluwarsa');
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
}
