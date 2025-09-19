<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan dashboard dengan daftar order user
    public function index()
    {
        // Mengambil semua orders untuk tampilan detail
        $orders = Order::where('user_id', Auth::id())
                       ->latest()
                       ->with(['orderItems.product', 'feedback'])
                       ->get();

        // Menghitung statistik dengan mengecualikan order yang dibatalkan
        $validOrders = $orders->whereNotIn('status', ['Cancelled']);
        $completedOrders = $orders->whereIn('status', ['Delivered', 'Completed']);
        
        // Menghitung total pengeluaran hanya dari order yang tidak dibatalkan
        $totalSpent = $validOrders->sum('total_amount');

        return view('dashboard', compact('orders', 'validOrders', 'completedOrders', 'totalSpent'));
    }

    // Membatalkan order jika status masih pending/processing
    public function cancel(Order $order)
    {
        // Pastikan order ini milik user yang login
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (in_array($order->status, ['Pending', 'Processing'])) {
            $order->update(['status' => 'Cancelled']);
            return redirect()->route('dashboard')->with('success', 'Order berhasil dibatalkan.');
        }

        return redirect()->route('dashboard')->with('error', 'Order sudah diproses, tidak bisa dibatalkan.');
    }
}
