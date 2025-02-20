<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BentukObatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bentuk_obat')->insert([
            [
                'nama_bentuk_obat' => 'Tablet',
                'deskripsi_bentuk_obat' => 'Obat berbentuk padat, biasanya bulat atau oval, yang dibuat dengan cara dipadatkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Kapsul',
                'deskripsi_bentuk_obat' => 'Obat berbentuk silinder dengan cangkang gelatin yang berisi serbuk atau cairan obat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Sirup',
                'deskripsi_bentuk_obat' => 'Obat cair dengan rasa manis yang diminum langsung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Suspensi',
                'deskripsi_bentuk_obat' => 'Obat cair yang mengandung partikel padat halus yang tidak larut, harus dikocok sebelum digunakan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Obat Tetes',
                'deskripsi_bentuk_obat' => 'Obat cair yang digunakan dalam bentuk tetesan, biasanya untuk mata, telinga, atau hidung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Emulsi',
                'deskripsi_bentuk_obat' => 'Obat cair yang merupakan campuran dua cairan yang tidak saling larut, seperti minyak dan air.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Larutan',
                'deskripsi_bentuk_obat' => 'Obat cair yang bahan aktifnya terlarut sepenuhnya dalam pelarut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Eliksir',
                'deskripsi_bentuk_obat' => 'Obat cair dengan campuran alkohol dan air, biasanya dengan rasa manis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Serbuk',
                'deskripsi_bentuk_obat' => 'Obat dalam bentuk bubuk halus yang bisa dilarutkan atau langsung diminum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Injeksi',
                'deskripsi_bentuk_obat' => 'Obat cair yang diberikan melalui suntikan ke dalam tubuh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Obat Oles',
                'deskripsi_bentuk_obat' => 'Obat yang dioleskan langsung ke kulit untuk pengobatan lokal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Supositoria',
                'deskripsi_bentuk_obat' => 'Obat padat yang dimasukkan ke dalam rektum, vagina, atau uretra, dan meleleh pada suhu tubuh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Aerosol',
                'deskripsi_bentuk_obat' => 'Obat yang dikemas dalam bentuk semprotan atau gas untuk dihirup.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Serbuk Inhalasi',
                'deskripsi_bentuk_obat' => 'Obat berbentuk serbuk halus yang dihirup melalui alat khusus.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Obat Tempel atau Implan',
                'deskripsi_bentuk_obat' => 'Obat yang ditempelkan pada kulit atau ditanam di bawah kulit untuk pelepasan zat aktif secara perlahan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_bentuk_obat' => 'Ekstrak',
                'deskripsi_bentuk_obat' => 'Obat yang dibuat dari bahan alami dengan mengambil komponen aktifnya melalui proses ekstraksi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
