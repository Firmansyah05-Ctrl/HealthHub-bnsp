<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\ShopRequest;

class AdminController extends Controller
{
    public function index()
    {
        // Calculate statistics with improved algorithm
        // Only active orders (excluding cancelled) are counted for total and revenue calculations
        $validStatuses = ['pending', 'shipped', 'delivered']; // Define valid statuses for calculations
        
        $statistics = [
            // Total orders excluding cancelled ones for accurate business metrics
            'total_orders' => Order::whereIn('status', $validStatuses)->count(),
            
            // Total revenue from all active orders (excluding cancelled)
            'total_revenue' => Order::whereIn('status', $validStatuses)->sum('total_amount'),
            
            // All statistics for dashboard
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock'),
            'total_categories' => Category::count(),
            // User statistics with better algorithm - consistent with UserController
            'total_users' => User::where('role', 'user')->count(), // Only regular users (matches admin/users page)
            'total_all_users' => User::count(), // All users including admin (for reference only)
            'active_users' => User::where('role', 'user')
                ->whereHas('orders', function($query) {
                    $query->where('created_at', '>=', now()->subMonths(3)); // Active in last 3 months
                })
                ->count(),
            'new_users_this_month' => User::where('role', 'user')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_feedback' => Feedback::count(),
            'total_shop_requests' => ShopRequest::count(),
            
            // Order status breakdown
            'pending_orders' => Order::where('status', 'pending')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            
            // Recent orders for dashboard display
            'recent_orders' => Order::with(['user', 'orderItems'])->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('statistics'));
    }
}
