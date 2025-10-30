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
            // TENDA CAMPING
            [
                'kode_unit' => 'TND-001',
                'nama_unit' => 'Tenda Dome 2 Orang Coleman',
                'merk' => 'Coleman',
                'kapasitas' => '2 Orang',
                'deskripsi' => 'Tenda dome compact untuk 2 orang dengan sistem ventilasi yang baik. Dilengkapi dengan fly sheet anti air dan tiang aluminium yang ringan namun kuat. Cocok untuk camping ringan dan backpacking.',
                'foto' => 'PinjemTent\public\images\units\tent1.png',
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
                'foto' => 'PinjemTent\public\images\units\tent2.png',
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
                'foto' => 'PinjemTent\public\images\units\tent3.png',
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
                'foto' => 'PinjemTent\public\images\units\tent1.png',
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
                'foto' => 'PinjemTent\public\images\units\tent2.png',
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
                'foto' => 'https://images.unsplash.com/photo-1563299796-17596ed6b017?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1551524164-6ca04ac833fb?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop',
                'status' => 'tersedia',
                'stok' => 7,
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
                'foto' => 'https://images.unsplash.com/photo-1520175480921-4edfa2983e0f?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1622260614153-03223fb72052?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1486022338407-7c73f3487929?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1566471539559-eafe1badc42b?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1526304760382-3591d3840148?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
                'status' => 'tersedia',
                'stok' => 30,
                'harga_sewa_per_hari' => 10000.00,
                'denda_per_hari' => 2000.00,
                'harga_beli' => 250000.00,
            ],

            // ALAT HIKING
            [
                'kode_unit' => 'HIK-001',
                'nama_unit' => 'Trekking Pole Carbon Fiber',
                'merk' => 'Black Diamond',
                'kapasitas' => 'Adjustable 110-140cm',
                'deskripsi' => 'Trekking pole carbon fiber yang sangat ringan namun kuat. Dilengkapi dengan tungsten carbide tip, adjustable length, dan comfortable grip.',
                'foto' => 'https://images.unsplash.com/photo-1551524164-bcea769a30ce?w=400&h=300&fit=crop',
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
                'foto' => 'https://images.unsplash.com/photo-1523362628745-0c100150b504?w=400&h=300&fit=crop',
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
                'kapasitas' => '3 Liter Capacity',
                'deskripsi' => 'Hydration bladder 3L dengan bite valve yang mudah digunakan. Dilengkapi dengan antimicrobial treatment dan leak-proof design. Perfect untuk long distance hiking.',
                'foto' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop',
                'status' => 'tersedia',
                'stok' => 15,
                'harga_sewa_per_hari' => 18000.00,
                'denda_per_hari' => 3500.00,
                'harga_beli' => 320000.00,
            ]
        ];

        foreach ($units as $unitData) {
            $unit = Unit::create($unitData);
        }

        // Attach categories to units based on their type
        $this->attachKategorisToUnits();
    }

    /**
     * Attach categories to units based on unit names
     */
    private function attachKategorisToUnits(): void
    {
        $units = Unit::all();
        $kategoris = Kategori::all()->keyBy('nama_kategori');

        foreach ($units as $unit) {
            $unitName = strtolower($unit->nama_unit);
            $attachKategoris = [];

            // Determine categories based on unit name and kode_unit
            if (str_contains($unitName, 'tenda') || str_contains($unit->kode_unit, 'TND')) {
                $attachKategoris[] = $kategoris->get('Tenda Camping')?->id;
            }
            if (str_contains($unitName, 'sleeping') || str_contains($unitName, 'bag') || str_contains($unit->kode_unit, 'SLP')) {
                $attachKategoris[] = $kategoris->get('Sleeping Bag')?->id;
            }
            if (str_contains($unitName, 'kompor') || str_contains($unitName, 'cookset') || str_contains($unitName, 'jetboil') || str_contains($unit->kode_unit, 'MSK')) {
                $attachKategoris[] = $kategoris->get('Alat Masak')?->id;
            }
            if (str_contains($unitName, 'tas') || str_contains($unitName, 'carrier') || str_contains($unit->kode_unit, 'CAR')) {
                $attachKategoris[] = $kategoris->get('Tas Carrier')?->id;
            }
            if (str_contains($unitName, 'headlamp') || str_contains($unitName, 'lantern') || str_contains($unit->kode_unit, 'LGT')) {
                $attachKategoris[] = $kategoris->get('Peralatan Pencahayaan')?->id;
            }
            if (str_contains($unitName, 'kompas') || str_contains($unitName, 'gps') || str_contains($unit->kode_unit, 'NAV')) {
                $attachKategoris[] = $kategoris->get('Alat Navigasi')?->id;
            }
            if (str_contains($unitName, 'matras') || str_contains($unitName, 'bantal') || str_contains($unit->kode_unit, 'BED')) {
                $attachKategoris[] = $kategoris->get('Perlengkapan Tidur')?->id;
            }
            if (str_contains($unitName, 'trekking') || str_contains($unitName, 'pole') || str_contains($unit->kode_unit, 'HIK')) {
                $attachKategoris[] = $kategoris->get('Alat Hiking')?->id;
            }
            if (str_contains($unitName, 'water') || str_contains($unitName, 'hydration') || str_contains($unitName, 'filter') || str_contains($unit->kode_unit, 'WTR')) {
                $attachKategoris[] = $kategoris->get('Peralatan Air')?->id;
            }

            // Filter out null values and attach
            $attachKategoris = array_filter($attachKategoris);
            if (!empty($attachKategoris)) {
                // Detach existing categories first to avoid duplicates
                $unit->kategoris()->detach();
                $unit->kategoris()->attach($attachKategoris);

                // Log the attachment for debugging
                echo "Unit '{$unit->nama_unit}' attached to " . count($attachKategoris) . " categories\n";
            }
        }
    }
}
