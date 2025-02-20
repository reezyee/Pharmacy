<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Ambil role berdasarkan nama
        $adminRole = Role::where('name', 'Admin')->first();
        $apotekerRole = Role::where('name', 'Apoteker')->first();
        $kasirRole = Role::where('name', 'Kasir')->first();
        $dokterRole = Role::where('name', 'Dokter')->first();
        $publicRole = Role::where('name', 'Pelanggan')->first();

        // Pastikan bahwa role ditemukan
        if ($adminRole && $apotekerRole && $kasirRole && $dokterRole && $publicRole) {
            // Tambahkan beberapa user dengan role tertentu
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'phone' => '085123456789',
                'address' => 'Jalan Jalan',
                'password' => Hash::make('admin'),
                'role_id' => $adminRole->id, // Role Admin
            ]);

            User::create([
                'name' => 'Apoteker',
                'email' => 'apoteker@example.com',
                'phone' => '081234567890',
                'address' => 'Jalan Jalan',
                'password' => Hash::make('apoteker'),
                'role_id' => $apotekerRole->id, // Role Apoteker
            ]);

            User::create([
                'name' => 'Kasir',
                'email' => 'kasir@example.com',
                'phone' => '012345678900',
                'address' => 'Jalan Jalan',
                'password' => Hash::make('kasir'),
                'role_id' => $kasirRole->id, // Role Kasir
            ]);

            User::create([
                'name' => 'Dokter',
                'email' => 'dokter@example.com',
                'phone' => '123123123123',
                'address' => 'Jalan Jalan',
                'password' => Hash::make('dokter'),
                'role_id' => $dokterRole->id, // Role Dokter
            ]);
        } else {
            // Jika role tidak ditemukan, beri pesan error
            echo "Role tidak ditemukan! Pastikan Anda telah menjalankan RolesSeeder terlebih dahulu.";
        }
    }
}
