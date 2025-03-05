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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('resep_id')->nullable()->constrained('reseps')->nullOnDelete();
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0); // Ongkir
            $table->decimal('handling_fee', 10, 2)->default(0); // Biaya COD
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('payment_method');
            $table->string('payment_status')->default('pending');
            $table->text('shipping_address');
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->text('notes')->nullable();
            $table->string('cart_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
