<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample images first
        $this->createSampleImages();

        $units = [
            // TENDA CAMPING
            [
                'kode_unit' => 'TND-001',
                'nama_unit' => 'Tenda Dome 2 Orang Coleman',
                'merk' => 'Coleman',
                'kapasitas' => '2 Orang',
                'deskripsi' => 'Tenda dome compact untuk 2 orang dengan sistem ventilasi yang baik. Dilengkapi dengan fly sheet anti air dan tiang aluminium yang ringan namun kuat. Cocok untuk camping ringan dan backpacking.',
                'foto' => 'tent-dome-2.jpg',
                'status' => 'tersedia',
                'stok' => 8,
                'harga_sewa_per_hari' => 50000.00,
                'denda_per_hari' => 10000.00,
                'harga_beli' => 750000.00,
            ],
            [
                'kode_unit' => 'TND-002',
                'nama_unit' => 'Tenda Dome 4 Orang Eiger',
                'merk' => 'Eiger',
                'kapasitas' => '4 Orang',
                'deskripsi' => 'Tenda dome untuk 4 orang dengan ruang yang spacious. Features double layer dengan inner tent breathable dan outer tent waterproof. Setup mudah dengan color coded poles.',
                'foto' => 'tent-dome-4.jpg',
                'status' => 'tersedia',
                'stok' => 6,
                'harga_sewa_per_hari' => 75000.00,
                'denda_per_hari' => 15000.00,
                'harga_beli' => 1200000.00,
            ],
            [
                'kode_unit' => 'TND-003',
                'nama_unit' => 'Tenda Tunnel 6 Orang Naturehike',
                'merk' => 'Naturehike',
                'kapasitas' => '6 Orang',
                'deskripsi' => 'Tenda tunnel spacious untuk 6 orang dengan tambahan area vestibule untuk gear storage. Konstruksi premium dengan material 210T ripstop polyester dan waterproof rating 3000mm.',
                'foto' => 'tent-tunnel-6.jpg',
                'status' => 'tersedia',
                'stok' => 4,
                'harga_sewa_per_hari' => 120000.00,
                'denda_per_hari' => 25000.00,
                'harga_beli' => 2200000.00,
            ],
            [
                'kode_unit' => 'TND-004',
                'nama_unit' => 'Tenda Family 8 Orang Coleman',
                'merk' => 'Coleman',
                'kapasitas' => '8 Orang',
                'deskripsi' => 'Tenda family besar untuk 8 orang dengan 2 compartment terpisah. Dilengkapi dengan area living room di tengah. Perfect untuk family camping dengan standing height yang nyaman.',
                'foto' => 'tent-family-8.jpg',
                'status' => 'tersedia',
                'stok' => 2,
                'harga_sewa_per_hari' => 180000.00,
                'denda_per_hari' => 35000.00,
                'harga_beli' => 3500000.00,
            ],
            [
                'kode_unit' => 'TND-005',
                'nama_unit' => 'Tenda Ultra Light 1 Orang',
                'merk' => 'MSR',
                'kapasitas' => '1 Orang',
                'deskripsi' => 'Tenda ultralight single person untuk ultralight backpacking. Berat hanya 1.2kg dengan packed size yang sangat compact. Material premium dengan durabilitas tinggi.',
                'foto' => 'tent-ultralight-1.jpg',
                'status' => 'tersedia',
                'stok' => 5,
                'harga_sewa_per_hari' => 80000.00,
                'denda_per_hari' => 15000.00,
                'harga_beli' => 4500000.00,
            ],

            // ALAT MASAK
            [
                'kode_unit' => 'MSK-001',
                'nama_unit' => 'Kompor Gas Portable Single Burner',
                'merk' => 'Trangia',
                'kapasitas' => '1 Burner - 3500W',
                'deskripsi' => 'Kompor gas portable single burner dengan kontrol api yang presisi. Dilengkapi dengan wind shield dan sistem ignition piezo. Compatible dengan cartridge gas standard.',
                'foto' => 'stove-single.jpg',
                'status' => 'tersedia',
                'stok' => 12,
                'harga_sewa_per_hari' => 25000.00,
                'denda_per_hari' => 5000.00,
                'harga_beli' => 350000.00,
            ],
            [
                'kode_unit' => 'MSK-002',
                'nama_unit' => 'Kompor Gas Double Burner',
                'merk' => 'Coleman',
                'kapasitas' => '2 Burner - 7000W',
                'deskripsi' => 'Kompor gas double burner untuk group camping. Dilengkapi dengan wind guard dan independent burner control. Cocok untuk memasak untuk banyak orang.',
                'foto' => 'stove-double.jpg',
                'status' => 'tersedia',
                'stok' => 6,
                'harga_sewa_per_hari' => 40000.00,
                'denda_per_hari' => 8000.00,
                'harga_beli' => 650000.00,
            ],
            [
                'kode_unit' => 'MSK-003',
                'nama_unit' => 'Nesting Cookset 4 Person',
                'merk' => 'GSI Outdoors',
                'kapasitas' => '4 Person Set',
                'deskripsi' => 'Set peralatan masak lengkap untuk 4 orang yang dapat disusun compact. Termasuk pot, pan, plates, bowls, cups, dan utensils. Material anodized aluminum yang ringan.',
                'foto' => 'cookset-4person.jpg',
                'status' => 'tersedia',
                'stok' => 8,
                'harga_sewa_per_hari' => 35000.00,
                'denda_per_hari' => 7000.00,
                'harga_beli' => 850000.00,
            ],
            [
                'kode_unit' => 'MSK-004',
                'nama_unit' => 'Jetboil Flash Cooking System',
                'merk' => 'Jetboil',
                'kapasitas' => '1 Liter Capacity',
                'deskripsi' => 'Sistem memasak all-in-one yang sangat efisien. Dapat mendidihkan 500ml air dalam 100 detik. Dilengkapi dengan heat exchanger dan insulated cozy.',
                'foto' => 'jetboil-flash.jpg',
                'status' => 'tersedia',
                'stok' => 4,
                'harga_sewa_per_hari' => 60000.00,
                'denda_per_hari' => 12000.00,
                'harga_beli' => 1800000.00,
            ],

            // TAS CARRIER
            [
                'kode_unit' => 'CAR-001',
                'nama_unit' => 'Tas Carrier 40L Daypack',
                'merk' => 'Deuter',
                'kapasitas' => '40 Liter',
                'deskripsi' => 'Tas carrier 40L perfect untuk day hiking dan overnight trip. Dilengkapi dengan Aircontact back system, hip belt, dan multiple compartments.',
                'foto' => 'carrier-40l.jpg',
                'status' => 'tersedia',
                'stok' => 15,
                'harga_sewa_per_hari' => 25000.00,
                'denda_per_hari' => 5000.00,
                'harga_beli' => 650000.00,
            ],
            [
                'kode_unit' => 'CAR-002',
                'nama_unit' => 'Tas Carrier 60L Trekking',
                'merk' => 'Osprey',
                'kapasitas' => '60 Liter',
                'deskripsi' => 'Tas carrier 60L untuk multi-day trekking. Features Anti-Gravity suspension system, integrated rain cover, dan sleeping bag compartment.',
                'foto' => 'carrier-60l.jpg',
                'status' => 'tersedia',
                'stok' => 10,
                'harga_sewa_per_hari' => 35000.00,
                'denda_per_hari' => 7000.00,
                'harga_beli' => 2200000.00,
            ],
            [
                'kode_unit' => 'CAR-003',
                'nama_unit' => 'Tas Carrier 80L Expedition',
                'merk' => 'Gregory',
                'kapasitas' => '80 Liter',
                'deskripsi' => 'Tas carrier 80L untuk expedition dan long-distance trekking. Dilengkapi dengan adjustable torso, multiple access points, dan robust construction.',
                'foto' => 'carrier-80l.jpg',
                'status' => 'tersedia',
                'stok' => 6,
                'harga_sewa_per_hari' => 50000.00,
                'denda_per_hari' => 10000.00,
                'harga_beli' => 3500000.00,
            ],

            // SLEEPING BAG
            [
                'kode_unit' => 'SLP-001',
                'nama_unit' => 'Sleeping Bag Summer 15°C',
                'merk' => 'Coleman',
                'kapasitas' => '+15°C Rating',
                'deskripsi' => 'Sleeping bag untuk cuaca hangat dengan comfort rating +15°C. Lightweight dan compact, cocok untuk summer camping dan lowland hiking.',
                'foto' => 'sleeping-summer.jpg',
                'status' => 'tersedia',
                'stok' => 20,
                'harga_sewa_per_hari' => 20000.00,
                'denda_per_hari' => 4000.00,
                'harga_beli' => 450000.00,
            ],
            [
                'kode_unit' => 'SLP-002',
                'nama_unit' => 'Sleeping Bag Mummy 0°C',
                'merk' => 'The North Face',
                'kapasitas' => '0°C Rating',
                'deskripsi' => 'Sleeping bag mummy shape dengan comfort rating 0°C. Dilengkapi dengan down insulation dan mummy hood untuk maximum warmth retention.',
                'foto' => 'sleeping-mummy.jpg',
                'status' => 'tersedia',
                'stok' => 12,
                'harga_sewa_per_hari' => 40000.00,
                'denda_per_hari' => 8000.00,
                'harga_beli' => 1200000.00,
            ],
            [
                'kode_unit' => 'SLP-003',
                'nama_unit' => 'Sleeping Bag Winter -10°C',
                'merk' => 'Mountain Hardwear',
                'kapasitas' => '-10°C Rating',
                'deskripsi' => 'Sleeping bag untuk kondisi ekstrim dengan rating -10°C. Premium down fill dengan high loft insulation. Perfect untuk alpine camping dan winter expedition.',
                'foto' => 'sleeping-winter.jpg',
                'status' => 'tersedia',
                'stok' => 6,
                'harga_sewa_per_hari' => 70000.00,
                'denda_per_hari' => 15000.00,
                'harga_beli' => 3200000.00,
            ],

            // ALAT NAVIGASI
            [
                'kode_unit' => 'NAV-001',
                'nama_unit' => 'Kompas Analog Professional',
                'merk' => 'Suunto',
                'kapasitas' => 'Precision Navigation',
                'deskripsi' => 'Kompas analog professional dengan accuracy tinggi. Dilengkapi dengan adjustable declination, luminous dial, dan robust construction.',
                'foto' => 'compass-analog.jpg',
                'status' => 'tersedia',
                'stok' => 15,
                'harga_sewa_per_hari' => 15000.00,
                'denda_per_hari' => 3000.00,
                'harga_beli' => 350000.00,
            ],
            [
                'kode_unit' => 'NAV-002',
                'nama_unit' => 'GPS Handheld Garmin',
                'merk' => 'Garmin',
                'kapasitas' => 'GPS + GLONASS',
                'deskripsi' => 'GPS handheld dengan akurasi tinggi, dilengkapi dengan topographic maps dan waypoint navigation. Battery life hingga 25 jam.',
                'foto' => 'gps-handheld.jpg',
                'status' => 'maintenance',
                'stok' => 4,
                'harga_sewa_per_hari' => 50000.00,
                'denda_per_hari' => 10000.00,
                'harga_beli' => 4500000.00,
            ],

            // PERALATAN PENCAHAYAAN
            [
                'kode_unit' => 'LGT-001',
                'nama_unit' => 'Headlamp LED 400 Lumens',
                'merk' => 'Petzl',
                'kapasitas' => '400 Lumens',
                'deskripsi' => 'Headlamp LED dengan output 400 lumens. Dilengkapi dengan multiple lighting modes, red light mode, dan waterproof rating IPX4.',
                'foto' => 'headlamp-400.jpg',
                'status' => 'tersedia',
                'stok' => 25,
                'harga_sewa_per_hari' => 15000.00,
                'denda_per_hari' => 3000.00,
                'harga_beli' => 450000.00,
            ],
            [
                'kode_unit' => 'LGT-002',
                'nama_unit' => 'Lantern Camping LED Rechargeable',
                'merk' => 'Goal Zero',
                'kapasitas' => '350 Lumens',
                'deskripsi' => 'Lantern camping LED rechargeable dengan 350 lumens output. Dilengkapi dengan USB charging port, dimmer control, dan collapsible design.',
                'foto' => 'lantern-led.jpg',
                'status' => 'tersedia',
                'stok' => 12,
                'harga_sewa_per_hari' => 25000.00,
                'denda_per_hari' => 5000.00,
                'harga_beli' => 650000.00,
            ],

            // PERLENGKAPAN TIDUR
            [
                'kode_unit' => 'BED-001',
                'nama_unit' => 'Matras Self-Inflating',
                'merk' => 'Therm-a-Rest',
                'kapasitas' => 'R-Value 4.2',
                'deskripsi' => 'Matras self-inflating dengan R-value 4.2 untuk insulation yang excellent. Thickness 5cm dengan open-cell foam core dan durable fabric.',
                'foto' => 'mattress-self.jpg',
                'status' => 'tersedia',
                'stok' => 18,
                'harga_sewa_per_hari' => 30000.00,
                'denda_per_hari' => 6000.00,
                'harga_beli' => 1200000.00,
            ],
            [
                'kode_unit' => 'BED-002',
                'nama_unit' => 'Bantal Camping Inflatable',
                'merk' => 'Sea to Summit',
                'kapasitas' => 'Ultralight Design',
                'deskripsi' => 'Bantal camping inflatable yang sangat ringan dan compact. Dilengkapi dengan soft fabric surface dan adjustable firmness.',
                'foto' => 'pillow-inflatable.jpg',
                'status' => 'tersedia',
                'stok' => 30,
                'harga_sewa_per_hari' => 10000.00,
                'denda_per_hari' => 2000.00,
                'harga_beli' => 250000.00,
            ],

            // PERALATAN SURVIVAL
            [
                'kode_unit' => 'SRV-001',
                'nama_unit' => 'Emergency Shelter Bivvy',
                'merk' => 'Adventure Medical Kits',
                'kapasitas' => '1-2 Person',
                'deskripsi' => 'Emergency shelter bivvy untuk survival situation. Lightweight, windproof, dan waterproof. Dapat digunakan sebagai emergency shelter atau ground tarp.',
                'foto' => 'bivvy-emergency.jpg',
                'status' => 'tersedia',
                'stok' => 10,
                'harga_sewa_per_hari' => 20000.00,
                'denda_per_hari' => 4000.00,
                'harga_beli' => 350000.00,
            ],
            [
                'kode_unit' => 'SRV-002',
                'nama_unit' => 'Fire Starter Kit',
                'merk' => 'Light My Fire',
                'kapasitas' => 'All Weather',
                'deskripsi' => 'Fire starter kit lengkap dengan magnesium fire starter, tinder, dan waterproof matches. Essential untuk survival dan emergency situations.',
                'foto' => 'fire-starter.jpg',
                'status' => 'tersedia',
                'stok' => 15,
                'harga_sewa_per_hari' => 12000.00,
                'denda_per_hari' => 2500.00,
                'harga_beli' => 180000.00,
            ],

            // ALAT HIKING
            [
                'kode_unit' => 'HIK-001',
                'nama_unit' => 'Trekking Pole Carbon Fiber',
                'merk' => 'Black Diamond',
                'kapasitas' => 'Adjustable 110-140cm',
                'deskripsi' => 'Trekking pole carbon fiber yang sangat ringan namun kuat. Dilengkapi dengan tungsten carbide tip, adjustable length, dan comfortable grip.',
                'foto' => 'trekking-pole.jpg',
                'status' => 'tersedia',
                'stok' => 20,
                'harga_sewa_per_hari' => 20000.00,
                'denda_per_hari' => 4000.00,
                'harga_beli' => 850000.00,
            ],

            // PERALATAN AIR
            [
                'kode_unit' => 'WTR-001',
                'nama_unit' => 'Water Filter Portable',
                'merk' => 'LifeStraw',
                'kapasitas' => '1000L Capacity',
                'deskripsi' => 'Water filter portable yang dapat menyaring hingga 1000 liter air. Menghilangkan 99.9% bacteria dan parasites. Essential untuk hiking di area dengan sumber air alami.',
                'foto' => 'water-filter.jpg',
                'status' => 'tersedia',
                'stok' => 12,
                'harga_sewa_per_hari' => 25000.00,
                'denda_per_hari' => 5000.00,
                'harga_beli' => 450000.00,
            ],
            [
                'kode_unit' => 'WTR-002',
                'nama_unit' => 'Hydration Bladder 3L',
                'merk' => 'CamelBak',
                'kapasitas' => '3 Liter',
                'deskripsi' => 'Hydration bladder 3L dengan bite valve yang mudah digunakan. Dilengkapi dengan insulated tube dan leak-proof design.',
                'foto' => 'hydration-bladder.jpg',
                'status' => 'tersedia',
                'stok' => 15,
                'harga_sewa_per_hari' => 15000.00,
                'denda_per_hari' => 3000.00,
                'harga_beli' => 350000.00,
            ],
        ];

        foreach ($units as $unitData) {
            $unitData['created_at'] = now();
            $unitData['updated_at'] = now();
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
            return;
        }

        // Get category mappings
        $categoryMappings = [
            'Tenda Camping' => ['TND-001', 'TND-002', 'TND-003', 'TND-004', 'TND-005'],
            'Alat Masak' => ['MSK-001', 'MSK-002', 'MSK-003', 'MSK-004'],
            'Tas Carrier' => ['CAR-001', 'CAR-002', 'CAR-003'],
            'Sleeping Bag' => ['SLP-001', 'SLP-002', 'SLP-003'],
            'Alat Navigasi' => ['NAV-001', 'NAV-002'],
            'Peralatan Pencahayaan' => ['LGT-001', 'LGT-002'],
            'Perlengkapan Tidur' => ['BED-001', 'BED-002'],
            'Peralatan Survival' => ['SRV-001', 'SRV-002'],
            'Alat Hiking' => ['HIK-001'],
            'Peralatan Air' => ['WTR-001', 'WTR-002'],
        ];

        foreach ($categoryMappings as $categoryName => $unitCodes) {
            $category = $kategoris->where('nama_kategori', $categoryName)->first();
            if (!$category) continue;

            foreach ($unitCodes as $unitCode) {
                $unit = $units->where('kode_unit', $unitCode)->first();
                if ($unit) {
                    $unit->kategoris()->attach($category->id);
                }
            }
        }
    }

    private function createSampleImages(): void
    {
        $imagesPath = public_path('images/units');

        // Ensure directory exists
        if (!File::exists($imagesPath)) {
            File::makeDirectory($imagesPath, 0755, true);
        }

        // Create placeholder images with different sizes and colors
        $imageFiles = [
            // Tenda
            'tent-dome-2.jpg' => '#2563eb', // Blue
            'tent-dome-4.jpg' => '#059669', // Green
            'tent-tunnel-6.jpg' => '#dc2626', // Red
            'tent-family-8.jpg' => '#7c3aed', // Purple
            'tent-ultralight-1.jpg' => '#ea580c', // Orange

            // Alat Masak
            'stove-single.jpg' => '#374151', // Gray
            'stove-double.jpg' => '#1f2937', // Dark Gray
            'cookset-4person.jpg' => '#991b1b', // Dark Red
            'jetboil-flash.jpg' => '#1e40af', // Dark Blue

            // Tas Carrier
            'carrier-40l.jpg' => '#065f46', // Dark Green
            'carrier-60l.jpg' => '#7c2d12', // Dark Orange
            'carrier-80l.jpg' => '#581c87', // Dark Purple

            // Sleeping Bag
            'sleeping-summer.jpg' => '#fbbf24', // Yellow
            'sleeping-mummy.jpg' => '#ef4444', // Red
            'sleeping-winter.jpg' => '#3b82f6', // Blue

            // Navigasi
            'compass-analog.jpg' => '#8b5cf6', // Purple
            'gps-handheld.jpg' => '#10b981', // Emerald

            // Pencahayaan
            'headlamp-400.jpg' => '#f59e0b', // Amber
            'lantern-led.jpg' => '#06b6d4', // Cyan

            // Perlengkapan Tidur
            'mattress-self.jpg' => '#84cc16', // Lime
            'pillow-inflatable.jpg' => '#ec4899', // Pink

            // Survival
            'bivvy-emergency.jpg' => '#ef4444', // Red
            'fire-starter.jpg' => '#f97316', // Orange

            // Hiking
            'trekking-pole.jpg' => '#6b7280', // Gray

            // Air
            'water-filter.jpg' => '#0ea5e9', // Sky
            'hydration-bladder.jpg' => '#06b6d4', // Cyan
        ];

        foreach ($imageFiles as $filename => $color) {
            $imagePath = $imagesPath . '/' . $filename;

            if (!File::exists($imagePath)) {
                // Create a simple SVG placeholder
                $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="400" height="300" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
  <rect width="400" height="300" fill="' . $color . '"/>
  <text x="200" y="150" font-family="Arial, sans-serif" font-size="16" fill="white" text-anchor="middle" dy="0.3em">
    ' . pathinfo($filename, PATHINFO_FILENAME) . '
  </text>
  <rect x="50" y="50" width="300" height="200" fill="none" stroke="white" stroke-width="2" stroke-dasharray="5,5"/>
</svg>';

                File::put($imagePath, $svg);
            }
        }
    }
}
