<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'auth_method',
        'google_id',
        'avatar',
        'address',
        'role_id',
        'last_seen_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    public function updatePassword($currentPassword, $newPassword)
    {
        if (Hash::check($currentPassword, $this->password)) {
            $this->password = Hash::make($newPassword);
            $this->save();
            return true;
        }

        return false; // Jika password lama tidak cocok
    }
    public function deleteAvatar()
    {
        if ($this->avatar && Storage::exists('public/' . $this->avatar)) {
            Storage::delete('public/' . $this->avatar);
        }
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
