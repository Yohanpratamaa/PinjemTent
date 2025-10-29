<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\RentalHistoryService;
use App\Services\User\ReturnRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalHistoryController extends Controller
{
    protected $rentalHistoryService;
    protected $returnRequestService;

    public function __construct(
        RentalHistoryService $rentalHistoryService,
        ReturnRequestService $returnRequestService
    ) {
        $this->rentalHistoryService = $rentalHistoryService;
        $this->returnRequestService = $returnRequestService;
    }

    /**
     * Display a listing of user's rental history.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get filter parameters
        $filters = [
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'search' => $request->get('search'),
            'per_page' => $request->get('per_page', 10)
        ];

        // Get rental history with filters
        $rentals = $this->rentalHistoryService->getUserRentalHistory($user->id, $filters);

        // Get statistics
        $stats = $this->rentalHistoryService->getUserRentalStats($user->id);

        return view('user.rental-history.index', compact('rentals', 'stats', 'filters'));
    }

    /**
     * Display the specified rental detail.
     */
    public function show($id)
    {
        $user = Auth::user();

        // Get rental detail with authorization check
        $rental = $this->returnRequestService->getRentalWithReturnInfo($id, $user->id);

        if (!$rental) {
            return redirect()->route('user.rental-history.index')
                           ->with('error', 'Riwayat penyewaan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Get return availability info
        $returnInfo = $this->returnRequestService->getReturnAvailabilityInfo($rental);

        return view('user.rental-history.show', compact('rental', 'returnInfo'));
    }

    /**
     * Cancel rental (if allowed).
     */
    public function cancel($id)
    {
        $user = Auth::user();

        try {
            $result = $this->rentalHistoryService->cancelRental($id, $user->id);

            if ($result['success']) {
                return redirect()->route('user.rental-history.show', $id)
                               ->with('success', $result['message']);
            } else {
                return redirect()->route('user.rental-history.show', $id)
                               ->with('error', $result['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('user.rental-history.show', $id)
                           ->with('error', 'Terjadi kesalahan saat membatalkan penyewaan.');
        }
    }

    /**
     * Request return for rental.
     */
    public function requestReturn(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'return_message' => 'nullable|string|max:500'
        ]);

        try {
            $result = $this->returnRequestService->requestReturn(
                $id,
                $user->id,
                $request->return_message
            );

            if ($result['success']) {
                return redirect()->route('user.rental-history.show', $id)
                               ->with('success', $result['message']);
            } else {
                return redirect()->route('user.rental-history.show', $id)
                               ->with('error', $result['message']);
            }
        } catch (\Exception $e) {
            return redirect()->route('user.rental-history.show', $id)
                           ->with('error', 'Terjadi kesalahan saat mengajukan permintaan pengembalian.');
        }
    }
}
