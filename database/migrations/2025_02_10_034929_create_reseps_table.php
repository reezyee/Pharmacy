<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('pasien_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('pasien_nama')->nullable();
            $table->enum('tipe', ['dokter', 'pasien']);
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->json('obats')->nullable(); 
            $table->json('foto_resep')->nullable(); 
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reseps');
    }
};
