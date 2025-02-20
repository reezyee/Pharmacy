<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriData = [
            ['nama' => 'Alergi', 'image' => 'images/asma.png'],
            ['nama' => 'Anti Jamur', 'image' => 'images/asma.png'],
            ['nama' => 'Asam Urat', 'image' => 'images/asma.png'],
            ['nama' => 'Asma', 'image' => 'images/asma.png'],
            ['nama' => 'Darah Tinggi', 'image' => 'images/diabetes.png'],
            ['nama' => 'Diabetes', 'image' => 'images/diabetes.png'],
            ['nama' => 'Flu & Batuk', 'image' => 'images/diabetes.png'],
            ['nama' => 'Ibu & Anak', 'image' => 'images/ia.png'],
            ['nama' => 'Kecantikan & Perawatan Diri', 'image' => 'images/kpd.png'],
            ['nama' => 'Kesehatan Jantung', 'image' => 'images/kj.png'],
            ['nama' => 'Kesehatan Seksual', 'image' => 'images/ks.png'],
            ['nama' => 'Kolesterol', 'image' => 'images/ks.png'],
            ['nama' => 'Mata', 'image' => 'images/lk.png'],
            ['nama' => 'Nasal Care', 'image' => 'images/ns.png'],
            ['nama' => 'Obat Onkologi & Imunosupresan', 'image' => 'images/oi.png'],
            ['nama' => 'Obat Rutin', 'image' => 'images/or.jpeg'],
            ['nama' => 'Obat & Perawatan', 'image' => 'images/op.png'],
            ['nama' => 'Obat Minyak & Oles', 'image' => 'images/op.png'],
            ['nama' => 'Perangkat & Peralatan', 'image' => 'images/pp.png'],
            ['nama' => 'Penyakit Kulit', 'image' => 'images/pp.png'],
            ['nama' => 'Pereda Nyeri & Sakit', 'image' => 'images/pp.png'],
            ['nama' => 'Pusing & Demam', 'image' => 'images/pp.png'],
            ['nama' => 'Saluran Pencernaan', 'image' => 'images/sp.png'],
            ['nama' => 'Susu & Nutrisi', 'image' => 'images/susu.png'],
            ['nama' => 'Vitamin & Suplemen', 'image' => 'images/vs.png'],
            ['nama' => 'Weight Management', 'image' => 'images/bb.png'],
        ];

        foreach ($kategoriData as $kategori) {
            $imagePath = public_path($kategori['image']);

            // Pastikan gambar ada di public path, jika ada salin ke storage/public
            if (file_exists($imagePath)) {
                $imageContents = file_get_contents($imagePath);
                Storage::disk('public')->put($kategori['image'], $imageContents);
            }

            // Simpan kategori ke database
            DB::table('kategoris')->insert([
                'nama' => $kategori['nama'],
                'image' => $kategori['image']
            ]);
        }
    }
}
