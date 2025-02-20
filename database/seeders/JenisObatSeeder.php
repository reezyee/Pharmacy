<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisObatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_obat')->insert([
            [
                'nama_jenis_obat' => 'Obat Bebas',
                'deskripsi_jenis_obat' => 'Obat yang dapat dibeli tanpa resep dokter, biasanya digunakan untuk gejala ringan.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Obat Bebas Terbatas',
                'deskripsi_jenis_obat' => 'Obat yang dapat dibeli tanpa resep dokter, tetapi memiliki aturan penggunaan khusus yang harus diperhatikan.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Obat Keras',
                'deskripsi_jenis_obat' => 'Obat yang memerlukan resep dokter untuk pembelian dan penggunaannya, karena potensi efek samping yang serius.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Obat Psikotropika',
                'deskripsi_jenis_obat' => 'Obat yang memengaruhi sistem saraf pusat dan dapat menyebabkan perubahan suasana hati atau perilaku, memerlukan pengawasan ketat.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Obat Golongan Narkotika',
                'deskripsi_jenis_obat' => 'Obat yang digunakan untuk tujuan medis tertentu, seperti pereda nyeri berat, tetapi berpotensi menyebabkan ketergantungan.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Obat Herbal',
                'deskripsi_jenis_obat' => 'Obat yang berasal dari bahan alami seperti tumbuhan, biasanya digunakan untuk mendukung kesehatan.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_obat' => 'Jamu',
                'deskripsi_jenis_obat' => 'Obat tradisional Indonesia yang terbuat dari bahan alami dan digunakan untuk menjaga kesehatan atau mengatasi penyakit ringan.',
                'created_at' => now(),
            ],
        ]);
    }
}
