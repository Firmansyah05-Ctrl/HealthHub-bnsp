<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product']);

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by order ID or user name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
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

        $orders = $query->latest()->paginate(15);

        // Calculate statistics with improved algorithm
        // Only active orders (excluding cancelled) are counted for total and revenue calculations
        $validStatuses = ['pending', 'shipped', 'delivered']; // Define valid statuses for calculations
        
        $statistics = [
            // Total orders excluding cancelled ones for accurate business metrics
            'total_orders' => Order::whereIn('status', $validStatuses)->count(),
            
            // Individual status counts for detailed breakdown
            'pending_orders' => Order::where('status', 'pending')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            
            // Total revenue from all active orders (excluding cancelled)
            'total_revenue' => Order::whereIn('status', $validStatuses)->sum('total_amount'),
            
            // Monthly revenue calculation for current month (excluding cancelled)
            'monthly_revenue' => Order::whereIn('status', $validStatuses)
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->sum('total_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'statistics'));
    }



    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Check if status is already the same
        if ($oldStatus === $newStatus) {
            return redirect()->back()->with('info', "Status pesanan #{$order->id} sudah dalam status " . ucfirst($newStatus));
        }

        // Handle stock management based on status change
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            // Restore stock when order is cancelled (from any status)
            $this->restoreStock($order);
        }

        // Update order status - allow any status change
        $order->update([
            'status' => $newStatus,
            'updated_at' => now()
        ]);

        // Create activity log
        $this->createOrderActivity($order, $oldStatus, $newStatus);

        $statusLabels = [
            'pending' => 'Menunggu Proses',
            'shipped' => 'Sedang Dikirim', 
            'delivered' => 'Telah Diterima',
            'cancelled' => 'Dibatalkan'
        ];

        $message = "Status pesanan #{$order->id} berhasil diubah menjadi " . $statusLabels[$newStatus];
        
        return redirect()->back()->with('success', $message);
    }



    private function restoreStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
        
        Log::info("Stock restored for cancelled order #{$order->id}");
    }

    private function createOrderActivity(Order $order, $oldStatus, $newStatus)
    {
        // This could be implemented to log order status changes
        // For now, we'll just use the updated_at timestamp
        $order->touch();
    }
}
