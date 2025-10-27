<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'kode_unit' => 'TND-001',
                'nama_unit' => 'Tenda Dome 4 Orang',
                'deskripsi' => 'Tenda dome untuk 4 orang dengan anti air',
                'status' => 'tersedia',
                'stok' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'TND-002',
                'nama_unit' => 'Tenda Tunnel 6 Orang',
                'deskripsi' => 'Tenda tunnel untuk 6 orang dengan ruang tambahan',
                'status' => 'tersedia',
                'stok' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'MSK-001',
                'nama_unit' => 'Kompor Portable',
                'deskripsi' => 'Kompor gas portable untuk camping',
                'status' => 'tersedia',
                'stok' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'MSK-002',
                'nama_unit' => 'Nesting Set',
                'deskripsi' => 'Set peralatan masak camping yang dapat disusun',
                'status' => 'tersedia',
                'stok' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'CAR-001',
                'nama_unit' => 'Tas Carrier 60L',
                'deskripsi' => 'Tas carrier kapasitas 60 liter untuk hiking',
                'status' => 'tersedia',
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'SLP-001',
                'nama_unit' => 'Sleeping Bag Mummy',
                'deskripsi' => 'Sleeping bag tipe mummy untuk suhu dingin',
                'status' => 'tersedia',
                'stok' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'NAV-001',
                'nama_unit' => 'Kompas Digital',
                'deskripsi' => 'Kompas digital dengan GPS untuk navigasi',
                'status' => 'maintenance',
                'stok' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($units as $unitData) {
            Unit::create($unitData);
        }

        // Attach kategori ke unit (many-to-many relationship)
        $this->attachKategorisToUnits();
    }

    private function attachKategorisToUnits(): void
    {
        $kategoris = Kategori::all();
        $units = Unit::all();

        // Tenda Dome - Kategori Tenda Camping
        $units->where('kode_unit', 'TND-001')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Tenda Camping')->first()->id);

        // Tenda Tunnel - Kategori Tenda Camping
        $units->where('kode_unit', 'TND-002')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Tenda Camping')->first()->id);

        // Kompor Portable - Kategori Alat Masak
        $units->where('kode_unit', 'MSK-001')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Alat Masak')->first()->id);

        // Nesting Set - Kategori Alat Masak
        $units->where('kode_unit', 'MSK-002')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Alat Masak')->first()->id);

        // Tas Carrier - Kategori Tas Carrier
        $units->where('kode_unit', 'CAR-001')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Tas Carrier')->first()->id);

        // Sleeping Bag - Kategori Sleeping Bag
        $units->where('kode_unit', 'SLP-001')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Sleeping Bag')->first()->id);

        // Kompas Digital - Kategori Alat Navigasi
        $units->where('kode_unit', 'NAV-001')->first()
            ->kategoris()->attach($kategoris->where('nama_kategori', 'Alat Navigasi')->first()->id);
    }
}
