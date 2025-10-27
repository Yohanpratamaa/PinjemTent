<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource class untuk format JSON response Unit
 * Layer ini mengatur struktur data yang dikembalikan ke client
 */
class UnitResource extends JsonResource
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
            'kode_unit' => $this->kode_unit,
            'nama_unit' => $this->nama_unit,
            'deskripsi' => $this->deskripsi,
            'status' => $this->status,
            'stok' => $this->stok,
            'kategoris' => KategoriResource::collection($this->whenLoaded('kategoris')),
            'peminjamans_count' => $this->whenCounted('peminjamans'),
            'current_peminjaman' => PeminjamanResource::collection(
                $this->whenLoaded('peminjamans', function () {
                    return $this->peminjamans->where('status', 'dipinjam');
                })
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
