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
                'deskripsi' => 'Tenda untuk kegiatan camping dan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Masak',
                'deskripsi' => 'Peralatan memasak untuk camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Tas Carrier',
                'deskripsi' => 'Tas besar untuk membawa perlengkapan camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sleeping Bag',
                'deskripsi' => 'Kantung tidur untuk camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Navigasi',
                'deskripsi' => 'Kompas, GPS dan alat navigasi lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Kategori::insert($kategoris);
    }
}
