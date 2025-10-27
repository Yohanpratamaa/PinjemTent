<?php

namespace App\Http\Responses;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     */
    public function toResponse($request): JsonResponse|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        if ($user && $user->role === 'user') {
            return redirect()->intended('/user/dashboard');
        }

        return redirect()->intended('/dashboard');
    }
}
