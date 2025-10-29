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
                'deskripsi_kategori' => 'Berbagai jenis tenda untuk kegiatan camping dan outdoor, mulai dari tenda dome, tunnel, hingga family tent dengan berbagai kapasitas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Masak',
                'deskripsi_kategori' => 'Peralatan memasak lengkap untuk camping termasuk kompor portable, panci set, dan peralatan makan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Tas Carrier',
                'deskripsi_kategori' => 'Tas carrier dan backpack dengan berbagai kapasitas untuk membawa perlengkapan hiking dan camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Sleeping Bag',
                'deskripsi_kategori' => 'Kantung tidur dengan berbagai rating suhu untuk kenyamanan tidur di alam terbuka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Navigasi',
                'deskripsi_kategori' => 'Kompas, GPS, altimeter dan alat navigasi lainnya untuk menjaga keamanan perjalanan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Peralatan Pencahayaan',
                'deskripsi_kategori' => 'Headlamp, senter, lampu camping, dan peralatan pencahayaan untuk aktivitas malam hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Perlengkapan Tidur',
                'deskripsi_kategori' => 'Matras, bantal camping, dan perlengkapan untuk kenyamanan tidur di alam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Peralatan Survival',
                'deskripsi_kategori' => 'Alat-alat survival dan emergency untuk keamanan dan keselamatan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Hiking',
                'deskripsi_kategori' => 'Trekking pole, sepatu gunung, dan peralatan khusus untuk hiking dan pendakian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Peralatan Air',
                'deskripsi_kategori' => 'Botol minum, water filter, dan peralatan untuk kebutuhan air selama camping',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
