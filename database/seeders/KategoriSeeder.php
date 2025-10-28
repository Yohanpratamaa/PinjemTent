<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Tenda Camping',
                'deskripsi_kategori' => 'Tenda untuk kegiatan camping dan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Masak',
                'deskripsi_kategori' => 'Peralatan memasak untuk camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Tas Carrier',
                'deskripsi_kategori' => 'Tas besar untuk membawa perlengkapan camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sleeping Bag',
                'deskripsi_kategori' => 'Kantung tidur untuk camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Navigasi',
                'deskripsi_kategori' => 'Kompas, GPS dan alat navigasi lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Kategori::insert($kategoris);
    }
}
