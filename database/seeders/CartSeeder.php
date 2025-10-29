<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $units = Unit::where('status', 'tersedia')->get();

        if ($users->isEmpty() || $units->isEmpty()) {
            return;
        }

        // Create sample cart items for some users
        $cartItems = [
            [
                'user_id' => $users->first()->id,
                'unit_id' => $units->where('kode_unit', 'TND-001')->first()?->id,
                'quantity' => 1,
                'tanggal_mulai' => Carbon::tomorrow(),
                'tanggal_selesai' => Carbon::tomorrow()->addDays(3),
                'notes' => 'Untuk camping weekend di Gunung Bromo',
                'harga_per_hari' => $units->where('kode_unit', 'TND-001')->first()?->harga_sewa_per_hari ?? 50000,
                'total_harga' => ($units->where('kode_unit', 'TND-001')->first()?->harga_sewa_per_hari ?? 50000) * 4, // 4 days
            ],
            [
                'user_id' => $users->first()->id,
                'unit_id' => $units->where('kode_unit', 'SLP-001')->first()?->id,
                'quantity' => 2,
                'tanggal_mulai' => Carbon::tomorrow(),
                'tanggal_selesai' => Carbon::tomorrow()->addDays(3),
                'notes' => 'Sleeping bag untuk 2 orang',
                'harga_per_hari' => $units->where('kode_unit', 'SLP-001')->first()?->harga_sewa_per_hari ?? 20000,
                'total_harga' => ($units->where('kode_unit', 'SLP-001')->first()?->harga_sewa_per_hari ?? 20000) * 4 * 2, // 4 days * 2 qty
            ],
            [
                'user_id' => $users->first()->id,
                'unit_id' => $units->where('kode_unit', 'MSK-001')->first()?->id,
                'quantity' => 1,
                'tanggal_mulai' => Carbon::tomorrow(),
                'tanggal_selesai' => Carbon::tomorrow()->addDays(3),
                'notes' => 'Kompor untuk memasak',
                'harga_per_hari' => $units->where('kode_unit', 'MSK-001')->first()?->harga_sewa_per_hari ?? 25000,
                'total_harga' => ($units->where('kode_unit', 'MSK-001')->first()?->harga_sewa_per_hari ?? 25000) * 4, // 4 days
            ],
        ];

        // Add cart items for second user if exists
        if ($users->count() > 1) {
            $secondUser = $users->skip(1)->first();
            $cartItems = array_merge($cartItems, [
                [
                    'user_id' => $secondUser->id,
                    'unit_id' => $units->where('kode_unit', 'TND-003')->first()?->id,
                    'quantity' => 1,
                    'tanggal_mulai' => Carbon::now()->addWeek(),
                    'tanggal_selesai' => Carbon::now()->addWeek()->addDays(5),
                    'notes' => 'Family camping long weekend',
                    'harga_per_hari' => $units->where('kode_unit', 'TND-003')->first()?->harga_sewa_per_hari ?? 120000,
                    'total_harga' => ($units->where('kode_unit', 'TND-003')->first()?->harga_sewa_per_hari ?? 120000) * 6, // 6 days
                ],
                [
                    'user_id' => $secondUser->id,
                    'unit_id' => $units->where('kode_unit', 'CAR-002')->first()?->id,
                    'quantity' => 2,
                    'tanggal_mulai' => Carbon::now()->addWeek(),
                    'tanggal_selesai' => Carbon::now()->addWeek()->addDays(5),
                    'notes' => 'Carrier untuk family trip',
                    'harga_per_hari' => $units->where('kode_unit', 'CAR-002')->first()?->harga_sewa_per_hari ?? 35000,
                    'total_harga' => ($units->where('kode_unit', 'CAR-002')->first()?->harga_sewa_per_hari ?? 35000) * 6 * 2, // 6 days * 2 qty
                ],
            ]);
        }

        foreach ($cartItems as $item) {
            if ($item['unit_id']) {
                Cart::create(array_merge($item, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
