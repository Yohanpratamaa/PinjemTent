<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display cart items for the authenticated user
     */
    public function index(): View
    {
        $cartItems = Cart::forUser(Auth::id())
            ->with(['unit.kategoris'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate total
        $grandTotal = $cartItems->sum('total_harga');

        return view('user.cart.index', compact('cartItems', 'grandTotal'));
    }

    /**
     * Add item to cart
     */
    public function store(Request $request): JsonResponse
    {
        // Log incoming request for debugging
        Log::info('Cart store request received', [
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'headers' => $request->headers->all()
        ]);

        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'notes' => 'nullable|string|max:500'
        ]);

        Log::info('Cart store validation passed', ['validated_data' => $validated]);

        try {
            $unit = Unit::findOrFail($validated['unit_id']);

            // Check unit availability
            if (!$unit->is_available) {
                Log::warning('Unit not available', ['unit_id' => $unit->id, 'status' => $unit->status]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unit ini sedang tidak tersedia.'
                ], 400);
            }

            // Check stock availability
            if ($validated['quantity'] > $unit->available_stock) {
                Log::warning('Insufficient stock', [
                    'unit_id' => $unit->id,
                    'requested_quantity' => $validated['quantity'],
                    'available_stock' => $unit->available_stock
                ]);
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi. Tersedia: {$unit->available_stock} unit."
                ], 400);
            }

            // Check if item already exists in cart for same dates
            $existingCartItem = Cart::forUser(Auth::id())
                ->where('unit_id', $validated['unit_id'])
                ->where('tanggal_mulai', $validated['tanggal_mulai'])
                ->where('tanggal_selesai', $validated['tanggal_selesai'])
                ->first();

            if ($existingCartItem) {
                // Update quantity
                $newQuantity = $existingCartItem->quantity + $validated['quantity'];

                if ($newQuantity > $unit->available_stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Total quantity melebihi stok tersedia. Maksimal: {$unit->available_stock} unit."
                    ], 400);
                }

                $existingCartItem->update([
                    'quantity' => $newQuantity,
                    'notes' => $validated['notes'] ?? $existingCartItem->notes
                ]);

                $cartItem = $existingCartItem;
                Log::info('Updated existing cart item', ['cart_item_id' => $cartItem->id]);
            } else {
                // Create new cart item
                $cartItem = Cart::create([
                    'user_id' => Auth::id(),
                    'unit_id' => $validated['unit_id'],
                    'quantity' => $validated['quantity'],
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                    'notes' => $validated['notes'] ?? null,
                    'harga_per_hari' => $unit->harga_sewa_per_hari
                ]);
                Log::info('Created new cart item', ['cart_item_id' => $cartItem->id]);
            }

            // Get updated cart count
            $cartCount = Cart::forUser(Auth::id())->count();

            Log::info('Cart operation successful', [
                'cart_item_id' => $cartItem->id,
                'cart_count' => $cartCount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang!',
                'cart_count' => $cartCount,
                'cart_item' => $cartItem->load('unit')
            ]);

        } catch (\Exception $e) {
            Log::error('Cart store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item ke keranjang. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Update cart item
     */
    public function update(Request $request, Cart $cart): JsonResponse
    {
        // Check ownership
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            // Check stock availability
            if ($validated['quantity'] > $cart->unit->available_stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok tidak mencukupi. Tersedia: {$cart->unit->available_stock} unit."
                ], 400);
            }

            $cart->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil diperbarui!',
                'cart_item' => $cart->fresh()->load('unit')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui item. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function destroy(Cart $cart): JsonResponse
    {
        // Check ownership
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $cart->delete();

            // Get updated cart count
            $cartCount = Cart::forUser(Auth::id())->count();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang!',
                'cart_count' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Clear all cart items for user
     */
    public function clear(): JsonResponse
    {
        try {
            Cart::forUser(Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan!',
                'cart_count' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengosongkan keranjang. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Get cart count for navbar
     */
    public function count(): JsonResponse
    {
        $count = Cart::forUser(Auth::id())->count();

        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Checkout - convert cart items to rentals
     */
    public function checkout(): RedirectResponse
    {
        $cartItems = Cart::forUser(Auth::id())->with('unit')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', 'Keranjang kosong. Tidak ada item untuk di-checkout.');
        }

        DB::beginTransaction();

        try {
            foreach ($cartItems as $cartItem) {
                // Create peminjaman record
                \App\Models\Peminjaman::create([
                    'user_id' => Auth::id(),
                    'unit_id' => $cartItem->unit_id,
                    'jumlah' => $cartItem->quantity,
                    'tanggal_pinjam' => $cartItem->tanggal_mulai,
                    'tanggal_kembali_rencana' => $cartItem->tanggal_selesai,
                    'harga_sewa_total' => $cartItem->total_harga,
                    'catatan' => $cartItem->notes,
                    'status' => 'pending' // Pending approval
                ]);

                // Delete cart item after successful conversion
                $cartItem->delete();
            }

            DB::commit();

            return redirect()->route('user.rental-history.index')
                ->with('success', 'Checkout berhasil! Semua pesanan akan diproses oleh admin.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('user.cart.index')
                ->with('error', 'Gagal melakukan checkout. Silakan coba lagi.');
        }
    }
}
