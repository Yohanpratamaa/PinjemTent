<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixUnitKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔧 Fixing Unit-Kategori relationships...');

        // Clear existing relationships
        DB::table('unit_kategori')->truncate();
        $this->command->info('📝 Cleared existing unit-kategori relationships');

        // Re-attach categories to units
        $this->attachKategorisToUnits();

        $this->command->info('✅ Unit-Kategori relationships fixed successfully!');
        $this->command->info('📊 Total relationships created: ' . DB::table('unit_kategori')->count());
    }

    /**
     * Attach categories to units based on unit names and codes
     */
    private function attachKategorisToUnits(): void
    {
        $units = Unit::all();
        $kategoris = Kategori::all()->keyBy('nama_kategori');
        $totalAttached = 0;

        foreach ($units as $unit) {
            $unitName = strtolower($unit->nama_unit);
            $unitCode = strtoupper($unit->kode_unit);
            $attachKategoris = [];

            // Determine categories based on unit name and kode_unit
            if (str_contains($unitName, 'tenda') || str_contains($unitCode, 'TND')) {
                $kategori = $kategoris->get('Tenda Camping');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'sleeping') || str_contains($unitName, 'bag') || str_contains($unitCode, 'SLP')) {
                $kategori = $kategoris->get('Sleeping Bag');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            // Fix: Alat Masak detection - more comprehensive
            if (str_contains($unitName, 'kompor') || str_contains($unitName, 'cookset') ||
                str_contains($unitName, 'jetboil') || str_contains($unitName, 'cooking') ||
                str_contains($unitName, 'nesting') || str_contains($unitCode, 'MSK')) {
                $kategori = $kategoris->get('Alat Masak');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'tas') || str_contains($unitName, 'carrier') || str_contains($unitCode, 'CAR')) {
                $kategori = $kategoris->get('Tas Carrier');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'headlamp') || str_contains($unitName, 'lantern') ||
                str_contains($unitName, 'led') || str_contains($unitCode, 'LGT')) {
                $kategori = $kategoris->get('Peralatan Pencahayaan');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'kompas') || str_contains($unitName, 'gps') ||
                str_contains($unitName, 'navigation') || str_contains($unitCode, 'NAV')) {
                $kategori = $kategoris->get('Alat Navigasi');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'matras') || str_contains($unitName, 'bantal') ||
                str_contains($unitName, 'inflating') || str_contains($unitName, 'inflatable') ||
                str_contains($unitCode, 'BED')) {
                $kategori = $kategoris->get('Perlengkapan Tidur');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            if (str_contains($unitName, 'trekking') || str_contains($unitName, 'pole') || str_contains($unitCode, 'HIK')) {
                $kategori = $kategoris->get('Alat Hiking');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            // Fix: Peralatan Air detection
            if (str_contains($unitName, 'water') || str_contains($unitName, 'hydration') ||
                str_contains($unitName, 'filter') || str_contains($unitName, 'bladder') ||
                str_contains($unitCode, 'WTR')) {
                $kategori = $kategoris->get('Peralatan Air');
                if ($kategori) $attachKategoris[] = $kategori->id;
            }

            // Filter out duplicates and null values
            $attachKategoris = array_unique(array_filter($attachKategoris));

            if (!empty($attachKategoris)) {
                $unit->kategoris()->attach($attachKategoris);
                $totalAttached += count($attachKategoris);

                $kategoriNames = $kategoris->whereIn('id', $attachKategoris)->pluck('nama_kategori')->toArray();
                $this->command->info("✓ Unit '{$unit->nama_unit}' → " . implode(', ', $kategoriNames));
            } else {
                $this->command->warn("⚠ Unit '{$unit->nama_unit}' tidak cocok dengan kategori manapun");
            }
        }

        $this->command->info("📈 Total kategori attachments: {$totalAttached}");
    }
}
