<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * Request class untuk validasi input saat membuat user baru
 * Layer ini bertanggung jawab untuk memvalidasi data yang masuk
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki otorisasi untuk request ini
     * Hanya admin yang dapat membuat user
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Aturan validasi yang diterapkan pada request
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'role' => [
                'required',
                'in:admin,user'
            ],
            'email_verified' => [
                'nullable',
                'boolean'
            ],
            'send_welcome_email' => [
                'nullable',
                'boolean'
            ]
        ];

        // Add phone validation only if column exists
        if (Schema::hasColumn('users', 'phone')) {
            $rules['phone'] = [
                'nullable',
                'string',
                'max:20'
            ];
        }

        return $rules;
    }

    /**
     * Pesan error custom untuk validasi
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama user wajib diisi',
            'name.max' => 'Nama user maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'email.max' => 'Email maksimal 255 karakter',
            'phone.max' => 'Nomor telepon maksimal 20 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role user wajib dipilih',
            'role.in' => 'Role harus berupa: admin atau user'
        ];
    }
}
