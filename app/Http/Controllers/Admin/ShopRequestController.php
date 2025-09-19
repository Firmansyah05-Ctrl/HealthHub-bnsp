<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopRequestController extends Controller
{
    /**
     * Display shop requests with filtering and search
     */
    public function index(Request $request)
    {
        $query = ShopRequest::with('user');

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by user name or shop name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('shop_name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $requests = $query->latest()->paginate(15);

        // Calculate statistics
        $statistics = [
            'total_requests' => ShopRequest::count(),
            'pending_requests' => ShopRequest::where('status', 'pending')->count(),
            'approved_requests' => ShopRequest::where('status', 'approved')->count(),
            'rejected_requests' => ShopRequest::where('status', 'rejected')->count(),
            'approval_rate' => ShopRequest::count() > 0 
                ? round((ShopRequest::where('status', 'approved')->count() / ShopRequest::count()) * 100, 1)
                : 0,
        ];

        return view('admin.shop_requests.index', compact('requests', 'statistics'));
    }

    /**
     * Show detailed view of a shop request
     */
    public function show(ShopRequest $shopRequest)
    {
        $shopRequest->load('user');
        return view('admin.shop_requests.show', compact('shopRequest'));
    }

    /**
     * Approve shop request with validation
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $shopRequest = ShopRequest::findOrFail($id);
            
            // Validate request can be approved
            if ($shopRequest->status !== 'pending') {
                return redirect()->back()->with('error', 'Hanya permohonan dengan status pending yang dapat disetujui.');
            }

            // Update request status
            $shopRequest->update([
                'status' => 'approved',
                'processed_at' => now(),
                'processed_by' => Auth::id()
            ]);

            // Keep user role as 'user' - no need to change to seller
            // Shop request approval doesn't change user role anymore
            // User remains as 'user' after shop request approval

            DB::commit();

            $message = "Permohonan toko '{$shopRequest->shop_name}' dari {$shopRequest->user->name} berhasil disetujui.";
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Reject shop request with reason
     */
    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $shopRequest = ShopRequest::findOrFail($id);
            
            // Validate request can be rejected
            if ($shopRequest->status !== 'pending') {
                return redirect()->back()->with('error', 'Hanya permohonan dengan status pending yang dapat ditolak.');
            }

            // Validate rejection reason
            $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ]);

            // Update request status
            $shopRequest->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'processed_at' => now(),
                'processed_by' => Auth::id()
            ]);

            DB::commit();

            $message = "Permohonan toko '{$shopRequest->shop_name}' dari {$shopRequest->user->name} berhasil ditolak.";
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses penolakan: ' . $e->getMessage());
        }
    }

    /**
     * Delete shop request permanently
     */
    public function destroy(ShopRequest $shopRequest)
    {
        $userName = $shopRequest->user->name ?? 'User tidak ditemukan';
        $shopName = $shopRequest->shop_name;
        
        $shopRequest->delete();

        return redirect()->route('admin.shop_requests.index')
                         ->with('success', "Permohonan toko '{$shopName}' dari {$userName} berhasil dihapus permanen.");
    }
}
