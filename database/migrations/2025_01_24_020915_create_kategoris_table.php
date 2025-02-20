<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('image')->nullable(); // Menyimpan path gambar
            $table->timestamps(); 
        });
        

        // Schema::create('child_kategoris', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nama');
        //     $table->foreignId('parent_kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
        //     $table->timestamps();
        // });

        // Schema::create('subchild_kategoris', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('nama');
        //     $table->foreignId('parent_child_kategori_id')->nullable()->constrained('child_kategoris')->onDelete('set null');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('subchild_kategoris');
        // Schema::dropIfExists('child_kategoris');
        Schema::dropIfExists('kategoris');
    }
};
