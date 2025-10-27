<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource class untuk format JSON response User
 * Layer ini mengatur struktur data yang dikembalikan ke client
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'initials' => $this->initials(),
            'is_admin' => $this->isAdmin(),
            'is_user' => $this->isUser(),
            'peminjamans_count' => $this->whenCounted('peminjamans'),
            'active_peminjamans' => PeminjamanResource::collection(
                $this->whenLoaded('peminjamans', function () {
                    return $this->peminjamans->where('status', 'dipinjam');
                })
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
