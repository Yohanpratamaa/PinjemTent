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
                'merk' => 'Coleman',
                'kapasitas' => '4 Orang',
                'deskripsi' => 'Tenda dome untuk 4 orang dengan anti air',
                'status' => 'tersedia',
                'stok' => 5,
                'harga_sewa_per_hari' => 75000.00,
                'denda_per_hari' => 15000.00,
                'harga_beli' => 1200000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'TND-002',
                'nama_unit' => 'Tenda Tunnel 6 Orang',
                'merk' => 'Eiger',
                'kapasitas' => '6 Orang',
                'deskripsi' => 'Tenda tunnel untuk 6 orang dengan ruang tambahan',
                'status' => 'tersedia',
                'stok' => 3,
                'harga_sewa_per_hari' => 100000.00,
                'denda_per_hari' => 20000.00,
                'harga_beli' => 1800000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'MSK-001',
                'nama_unit' => 'Kompor Portable',
                'merk' => 'Trangia',
                'kapasitas' => '2 Burner',
                'deskripsi' => 'Kompor gas portable untuk camping',
                'status' => 'tersedia',
                'stok' => 8,
                'harga_sewa_per_hari' => 25000.00,
                'denda_per_hari' => 5000.00,
                'harga_beli' => 350000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'MSK-002',
                'nama_unit' => 'Nesting Set',
                'merk' => 'GSI Outdoors',
                'kapasitas' => '4 Person Set',
                'deskripsi' => 'Set peralatan masak camping yang dapat disusun',
                'status' => 'tersedia',
                'stok' => 6,
                'harga_sewa_per_hari' => 20000.00,
                'denda_per_hari' => 4000.00,
                'harga_beli' => 280000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'CAR-001',
                'nama_unit' => 'Tas Carrier 60L',
                'merk' => 'Deuter',
                'kapasitas' => '60 Liter',
                'deskripsi' => 'Tas carrier kapasitas 60 liter untuk hiking',
                'status' => 'tersedia',
                'stok' => 10,
                'harga_sewa_per_hari' => 30000.00,
                'denda_per_hari' => 6000.00,
                'harga_beli' => 850000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'SLP-001',
                'nama_unit' => 'Sleeping Bag Mummy',
                'merk' => 'The North Face',
                'kapasitas' => '-5°C Rating',
                'deskripsi' => 'Sleeping bag tipe mummy untuk suhu dingin',
                'status' => 'tersedia',
                'stok' => 12,
                'harga_sewa_per_hari' => 40000.00,
                'denda_per_hari' => 8000.00,
                'harga_beli' => 950000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_unit' => 'NAV-001',
                'nama_unit' => 'Kompas Digital',
                'merk' => 'Garmin',
                'kapasitas' => 'GPS Ready',
                'deskripsi' => 'Kompas digital dengan GPS untuk navigasi',
                'status' => 'maintenance',
                'stok' => 4,
                'harga_sewa_per_hari' => 15000.00,
                'denda_per_hari' => 3000.00,
                'harga_beli' => 450000.00,
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

        if ($kategoris->isEmpty() || $units->isEmpty()) {
            return; // Skip if no categories or units exist
        }

        // Get category IDs for easier access
        $tendaCampingId = $kategoris->where('nama_kategori', 'Tenda Camping')->first()?->id;
        $alatMasakId = $kategoris->where('nama_kategori', 'Alat Masak')->first()?->id;
        $tasCarrierId = $kategoris->where('nama_kategori', 'Tas Carrier')->first()?->id;
        $sleepingBagId = $kategoris->where('nama_kategori', 'Sleeping Bag')->first()?->id;
        $alatNavigasiId = $kategoris->where('nama_kategori', 'Alat Navigasi')->first()?->id;

        // Attach categories to units if both exist
        $mappings = [
            'TND-001' => $tendaCampingId,  // Tenda Dome
            'TND-002' => $tendaCampingId,  // Tenda Tunnel
            'MSK-001' => $alatMasakId,     // Kompor Portable
            'MSK-002' => $alatMasakId,     // Nesting Set
            'CAR-001' => $tasCarrierId,    // Tas Carrier
            'SLP-001' => $sleepingBagId,   // Sleeping Bag
            'NAV-001' => $alatNavigasiId,  // Kompas Digital
        ];

        foreach ($mappings as $kodeUnit => $kategoriId) {
            if ($kategoriId) {
                $unit = $units->where('kode_unit', $kodeUnit)->first();
                if ($unit) {
                    $unit->kategoris()->attach($kategoriId);
                }
            }
        }
    }
}
