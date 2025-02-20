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
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->json('obats'); // Simpan dalam bentuk JSON
            $table->text('catatan')->nullable();
            $table->string('status')->default('active');
            $table->softDeletes(); // Tambahkan ini
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reseps');
    }
};
