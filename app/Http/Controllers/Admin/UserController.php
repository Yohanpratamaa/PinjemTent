<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\UserService;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'role' => $request->get('role'),
            'status' => $request->get('status'),
        ];

        $users = $this->userService->getAllUsers($filters, 15);

        // Get statistics
        $stats = [
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'active_rentals' => 0, // TODO: implement when peminjaman is ready
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Log data yang akan dibuat untuk debugging
        Log::info('👤 User CREATE Operation Started', [
            'operation' => 'CREATE',
            'route_method' => $request->method(),
            'route_action' => $request->route()->getActionName(),
            'request_data' => $request->except(['password', 'password_confirmation']),
            'user_id_auth' => Auth::id()
        ]);

        $validated = $request->validated();

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), // Hash sekali di sini
                'role' => $validated['role'],
                'email_verified_at' => ($validated['email_verified'] ?? false) ? now() : null,
            ];

            // Add phone only if it exists in the database schema
            if (Schema::hasColumn('users', 'phone')) {
                $data['phone'] = $validated['phone'] ?? null;
            }

            $user = $this->userService->createUser($data);

            Log::info('✅ User CREATE Successful', [
                'operation' => 'CREATE_SUCCESS',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'created_user' => $user->toArray(),
                'user_id_auth' => Auth::id()
            ]);

            // TODO: Send welcome email if requested

            return redirect()
                ->route('admin.users.show', $user)
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('❌ User CREATE Failed', [
                'operation' => 'CREATE_FAILED',
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation']),
                'user_id_auth' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $user->load(['peminjamans']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Log data yang akan diupdate untuk debugging
        Log::info('🔄 User UPDATE Operation Started (NOT DELETE)', [
            'operation' => 'UPDATE',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'route_method' => $request->method(),
            'route_action' => $request->route()->getActionName(),
            'old_data' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'raw_request' => $request->except(['password', 'password_confirmation']),
            'user_id_auth' => Auth::id()
        ]);

        $validated = $request->validated();

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            // Add phone only if it exists in the database schema
            if (Schema::hasColumn('users', 'phone')) {
                $data['phone'] = $validated['phone'] ?? null;
            }

            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $updatedUser = $this->userService->updateUser($user->id, $data);

            Log::info('✅ User UPDATE Successful (NOT DELETE)', [
                'operation' => 'UPDATE_SUCCESS',
                'user_id' => $user->id,
                'updated_user' => $updatedUser->toArray()
            ]);

            return redirect()
                ->route('admin.users.show', $updatedUser)
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('❌ User UPDATE Failed (NOT DELETE)', [
                'operation' => 'UPDATE_FAILED',
                'user_id' => $user->id,
                'error_message' => $e->getMessage(),
                'validated_data' => $validated,
                'user_id_auth' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Log::info('🗑️ User DELETE Operation Started (NOT UPDATE)', [
            'operation' => 'DELETE',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'user_id_auth' => Auth::id()
        ]);

        // Prevent deleting current admin user
        if ($user->id === Auth::id()) {
            Log::warning('User DELETE Blocked - Cannot delete own account', [
                'user_id' => $user->id,
                'attempted_by' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->with('error', 'You cannot delete your own account.');
        }

        try {
            $userData = $user->toArray(); // Backup data untuk log
            $this->userService->deleteUser($user->id);

            Log::info('🗑️ User DELETE Successful (NOT UPDATE)', [
                'operation' => 'DELETE_SUCCESS',
                'deleted_user' => $userData,
                'user_id_auth' => Auth::id()
            ]);

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('❌ User DELETE Failed (NOT UPDATE)', [
                'operation' => 'DELETE_FAILED',
                'user_id' => $user->id,
                'error_message' => $e->getMessage(),
                'user_id_auth' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
