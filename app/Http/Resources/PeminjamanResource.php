<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode_peminjaman' => $this->kode_peminjaman,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
            'unit' => [
                'id' => $this->unit->id,
                'nama' => $this->unit->nama,
                'kategori' => $this->unit->kategori->nama,
                'harga_sewa_per_hari_formatted' => 'Rp ' . number_format($this->unit->harga_sewa_per_hari, 0, ',', '.'),
                'denda_per_hari_formatted' => 'Rp ' . number_format($this->unit->denda_per_hari, 0, ',', '.'),
            ],
            'tanggal_pinjam' => $this->tanggal_pinjam->format('Y-m-d'),
            'tanggal_kembali_rencana' => $this->tanggal_kembali_rencana->format('Y-m-d'),
            'tanggal_kembali_aktual' => $this->tanggal_kembali_aktual?->format('Y-m-d'),
            'durasi_hari' => $this->calculateRentalDays(),
            'hari_terlambat' => $this->calculateLateDays(),
            'financial' => [
                'harga_sewa_total' => $this->harga_sewa_total,
                'harga_sewa_total_formatted' => $this->getFormattedHargaSewaTotal(),
                'denda_total' => $this->denda_total,
                'denda_total_formatted' => $this->getFormattedDendaTotal(),
                'total_bayar' => $this->total_bayar,
                'total_bayar_formatted' => $this->getFormattedTotalBayar(),
            ],
            'status' => $this->status,
            'catatan_peminjam' => $this->catatan_peminjam,
            'catatan_admin' => $this->catatan_admin,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
