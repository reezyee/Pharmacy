<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resep_id', // Pastikan ini ada!
        'order_number',
        'cart_token',
        'total_amount',
        'shipping_cost', // Tambahkan ongkir
        'handling_fee', // Tambahkan biaya COD
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'notes'
    ];

    /**
     * Auto-generate order number before creating.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(Str::random(8));
        });
    }

    /**
     * Relasi ke User (pemilik order).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relasi ke OrderItem (barang yang dipesan).
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Hitung total akhir (subtotal + ongkir + biaya COD).
     */
    public function getFinalTotalAttribute()
    {
        return $this->total_amount + $this->shipping_cost + $this->handling_fee;
    }

    public function resep(): BelongsTo
{
    return $this->belongsTo(Resep::class, 'resep_id');
}

}
