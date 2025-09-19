@extends('layouts.app')

@section('title', 'Kelola Pesanan - Admin HealthHub')
@section('description', 'Kelola dan monitor pesanan pelanggan di HealthHub.')

@push('styles')
<style>
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .filter-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.9);
    }
    
    /* Status Badge Styles - Using Inline Styles for better compatibility */
    
    /* Enhanced Product Display Styles */
    .product-item-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(8px);
    }
    
    .product-item-card:hover {
        transform: translateY(-1px) scale(1.02);
        box-shadow: 0 8px 20px rgba(20, 184, 166, 0.15);
    }
    
    .quantity-badge {
        background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%) !important;
        box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3) !important;
        color: white !important;
        font-weight: bold !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    /* Table enhancements */
    .enhanced-table {
        font-feature-settings: "tnum";
    }
    
    .enhanced-table td {
        vertical-align: top;
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }
    
    /* Smooth transitions for all interactive elements */
    .toggle-btn {
        transition: all 0.3s ease;
    }
    
    .toggle-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
    }
    
    /* Animation for expanding content */
    .expand-animation {
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                    opacity 0.3s ease;
    }
    
    /* Simple toggle button styles */
    button[data-order-id] {
        cursor: pointer !important;
        pointer-events: auto !important;
        z-index: 10 !important;
        position: relative !important;
    }
    
    button[data-order-id]:hover {
        transform: translateY(-1px) !important;
    }
    
    /* Container styles */
    [id^="order-products-"] {
        overflow: hidden;
        transition: opacity 0.3s ease;
    }
    
    [id^="order-products-"].hidden {
        display: none !important;
        opacity: 0 !important;
    }
    
    /* Product container animations */
    [id^="order-products-"] {
        transform-origin: top center;
    }
    
    [id^="order-products-"]:not(.hidden) {
        animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Custom scrollbar for better UX */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #14b8a6;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #0d9488;
    }
    
    /* Enhanced Order ID Badge */
    .order-id-badge {
        background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
        color: white;
        font-weight: bold;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(20, 184, 166, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Enhanced Product Cards */
    .primary-product {
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
        border-color: #14b8a6;
        transition: all 0.2s ease;
    }
    
    .primary-product:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(20, 184, 166, 0.15);
    }
    
    .additional-product {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border-color: #f59e0b;
        transition: all 0.2s ease;
    }
    
    .additional-product:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.15);
    }
    
    /* Enhanced Toggle Button */
    .toggle-products-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .toggle-products-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }
    
    .toggle-products-btn:hover::before {
        left: 100%;
    }
    
    /* Summary box styling */
    .products-summary {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    
    .products-summary:hover {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-color: #cbd5e1;
    }
</style>
@endpush

@push('scripts')
<script>
// Simplified and robust toggle function
function toggleProducts(orderId) {
    console.log('🔄 Toggle function called for order:', orderId);
    
    // Simple and direct element selection
    const container = document.getElementById('order-products-' + orderId);
    const button = document.querySelector('button[data-order-id="' + orderId + '"]');
    
    console.log('Element check:');
    console.log('- Container found:', !!container, container);
    console.log('- Button found:', !!button, button);
    
    if (!container) {
        console.error('❌ Container not found: order-products-' + orderId);
        return false;
    }
    
    if (!button) {
        console.error('❌ Button not found for order:', orderId);
        return false;
    }
    
    const isHidden = container.classList.contains('hidden');
    const span = button.querySelector('span');
    const icon = button.querySelector('svg');
    
    console.log('Current state - Hidden:', isHidden);
    
    if (isHidden) {
        // SHOW products
        console.log('�️ Showing products...');
        container.classList.remove('hidden');
        container.style.display = 'block';
        container.style.opacity = '1';
        container.style.maxHeight = 'none';
        
        if (span) span.textContent = 'Sembunyikan';
        if (icon) {
            icon.style.transform = 'rotate(180deg)';
            icon.style.transition = 'transform 0.3s ease';
        }
        
        // Keep consistent teal/cyan gradient colors
        // No color change to maintain consistency with other buttons
        
        console.log('✅ Products shown');
    } else {
        // HIDE products
        console.log('� Hiding products...');
        container.classList.add('hidden');
        container.style.display = 'none';
        container.style.opacity = '0';
        
        const itemCount = container.querySelectorAll('.product-item-card').length;
        if (span) span.textContent = 'Lihat ' + itemCount + ' produk lainnya';
        if (icon) {
            icon.style.transform = 'rotate(0deg)';
            icon.style.transition = 'transform 0.3s ease';
        }
        
        // Change button gradient back to teal/cyan for expand action
        button.classList.remove('from-red-500', 'to-pink-500', 'hover:from-red-600', 'hover:to-pink-600');
        button.classList.add('from-teal-500', 'to-cyan-500', 'hover:from-teal-600', 'hover:to-cyan-600');
        
        console.log('✅ Products hidden');
    }
    
    return false;
}

// Simple test function
window.testToggle = function(orderId) {
    console.log('🧪 Testing toggle for order:', orderId);
    return toggleProducts(orderId);
};

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Page loaded - Setting up toggle buttons');
    
    // Simple approach: find all buttons and attach direct event listeners
    const buttons = document.querySelectorAll('button[data-order-id]');
    console.log('Found', buttons.length, 'toggle buttons');
    
    buttons.forEach(function(button) {
        const orderId = button.getAttribute('data-order-id');
        console.log('Setting up button for order:', orderId);
        
        // Remove existing onclick to prevent conflicts
        button.removeAttribute('onclick');
        
        // Add click event listener
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('🖱️ Button clicked for order:', orderId);
            toggleProducts(orderId);
            return false;
        });
        
        // Verify container exists
        const container = document.getElementById('order-products-' + orderId);
        console.log('Order', orderId, '- Container exists:', !!container);
    });
    
    console.log('✅ Event setup completed');
    
    // Setup status update confirmations
    const forms = document.querySelectorAll('form[action*="orders"]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const select = this.querySelector('select[name="status"]');
            const newStatus = select.value;
            
            let confirmMessage = '';
            
            if (newStatus === 'cancelled') {
                confirmMessage = '⚠️ Yakin ingin membatalkan pesanan ini?\n\nStok produk akan dikembalikan secara otomatis.';
            } else if (newStatus === 'delivered') {
                confirmMessage = '✅ Konfirmasi pesanan telah diterima pelanggan?\n\nPastikan produk benar-benar sudah sampai.';
            } else if (newStatus === 'shipped') {
                confirmMessage = '📦 Konfirmasi pesanan sudah dikirim?\n\nPastikan produk sudah diserahkan ke ekspedisi.';
            }
            
            if (confirmMessage && !confirm(confirmMessage)) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('[class*="bg-green-"], [class*="bg-red-"], [class*="bg-blue-"]');
        alerts.forEach(function(alert) {
            if (alert.querySelector('svg')) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() { 
                    if (alert.parentNode) alert.parentNode.removeChild(alert); 
                }, 500);
            }
        });
    }, 5000);
});
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 rounded-xl flex items-center justify-between shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 rounded-xl flex items-center justify-between shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">Kelola Pesanan</h1>
                </div>
                <p class="text-indigo-100 text-lg">Monitor dan kelola pesanan pelanggan secara real-time</p>
            </div>
            <div class="hidden md:block">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $statistics['total_orders'] }}</div>
                        <div class="text-indigo-200 text-sm">Total Pesanan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">Rp {{ number_format($statistics['total_revenue'], 0, ',', '.') }}</div>
                        <div class="text-indigo-200 text-sm">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-2xl p-6 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-yellow-700">{{ $statistics['pending_orders'] }}</div>
                    <div class="text-yellow-600 text-sm font-medium">Pending</div>
                </div>
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-700">{{ $statistics['shipped_orders'] }}</div>
                    <div class="text-blue-600 text-sm font-medium">Shipped</div>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7l4-4m0 0l4 4m-4-4v18"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-700">{{ $statistics['delivered_orders'] }}</div>
                    <div class="text-green-600 text-sm font-medium">Delivered</div>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-rose-100 rounded-2xl p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-red-700">{{ $statistics['cancelled_orders'] }}</div>
                    <div class="text-red-600 text-sm font-medium">Cancelled</div>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card bg-white rounded-2xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan ID pesanan atau nama pelanggan..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="all">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <!-- Payment Method Filter -->
            <div>
                <select name="payment_method" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="all">Semua Metode</option>
                    <option value="postpaid" {{ request('payment_method') == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                    <option value="prepaid" {{ request('payment_method') == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors duration-200 font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Orders List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Daftar Pesanan</h2>
        </div>
        
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full enhanced-table">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>ID & Pelanggan</span>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200 min-w-[380px]">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <span>Detail Produk</span>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                    <span>Total</span>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Status</span>
                                </div>
                            </th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                    </svg>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gradient-to-r hover:from-teal-50 hover:to-cyan-50 transition-all duration-300 border-b border-gray-100 hover:shadow-md hover:border-teal-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!-- Order ID Badge -->
                                        <div class="mr-3">
                                            <div class="order-id-badge">
                                                #{{ $order->id }}
                                            </div>
                                        </div>
                                        
                                        <!-- Customer Avatar -->
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                            {{ substr($order->user->name ?? 'U', 0, 2) }}
                                        </div>
                                        
                                        <!-- Customer Info -->
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'User tidak ditemukan' }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->user->email ?? '-' }}</div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2 max-w-sm">
                                        <!-- Display First 3 Products -->
                                        @foreach($order->orderItems->take(3) as $item)
                                            <div class="product-item-card primary-product flex items-center space-x-3 rounded-xl p-3 shadow-sm">
                                                <!-- Product Quantity Badge -->
                                                <div class="flex-shrink-0">
                                                    <div class="quantity-badge w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" 
                                                         style="background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%); box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);">
                                                        {{ $item->quantity }}x
                                                    </div>
                                                </div>
                                                
                                                <!-- Product Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-semibold text-gray-900 truncate">
                                                        {{ $item->product->name ?? 'Produk tidak ditemukan' }}
                                                    </div>
                                                    <div class="text-xs font-medium text-teal-700">
                                                        Rp {{ number_format($item->price_per_item, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <!-- Hidden Additional Products -->
                                        @if($order->orderItems->count() > 3)
                                            <div id="order-products-{{ $order->id }}" 
                                                 class="hidden space-y-2"
                                                 style="display: none;">
                                                @foreach($order->orderItems->skip(3) as $item)
                                                    <div class="product-item-card additional-product flex items-center space-x-3 rounded-xl p-3 shadow-sm">
                                                        <div class="flex-shrink-0">
                                                            <div class="quantity-badge w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" 
                                                                 style="background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%); box-shadow: 0 2px 8px rgba(20, 184, 166, 0.3);">
                                                                {{ $item->quantity }}x
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="text-sm font-semibold text-gray-900 truncate">
                                                                {{ $item->product->name ?? 'Produk tidak ditemukan' }}
                                                            </div>
                                                            <div class="text-xs font-medium text-teal-700">
                                                                Rp {{ number_format($item->price_per_item, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <!-- Products Summary & Toggle Button -->
                                        <div class="mt-4 pt-3 products-summary rounded-lg p-3">
                                            <div class="flex items-center justify-between">
                                                <div class="text-xs text-gray-600">
                                                    <div class="font-semibold">{{ $order->orderItems->count() }} jenis produk</div>
                                                    <div class="text-gray-500">{{ $order->orderItems->sum('quantity') }} total item</div>
                                                </div>
                                                
                                                @if($order->orderItems->count() > 3)
                                                    <button type="button" 
                                                            data-order-id="{{ $order->id }}"
                                                            class="toggle-products-btn text-xs text-white font-medium bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 px-4 py-2 rounded-full flex items-center space-x-2 shadow-md hover:shadow-lg transform hover:scale-105"
                                                            style="cursor: pointer;">
                                                        <svg class="w-3 h-3 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                        <span>Lihat {{ $order->orderItems->count() - 3 }} produk lainnya</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusLower = strtolower(trim($order->status));
                                    @endphp
                                    
                                    @if($statusLower === 'pending')
                                        <div style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #92400e; border: 2px solid #d97706; box-shadow: 0 4px 12px -2px rgba(245, 158, 11, 0.3); display: inline-flex; align-items: center; padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 700; min-width: 110px; justify-content: center; text-transform: capitalize; transition: all 0.3s ease;">
                                            Pending
                                        </div>
                                    @elseif($statusLower === 'shipped')
                                        <div style="background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%); color: #1e3a8a; border: 2px solid #1d4ed8; box-shadow: 0 4px 12px -2px rgba(59, 130, 246, 0.3); display: inline-flex; align-items: center; padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 700; min-width: 110px; justify-content: center; text-transform: capitalize; transition: all 0.3s ease;">
                                            Shipped
                                        </div>
                                    @elseif($statusLower === 'delivered')
                                        <div style="background: linear-gradient(135deg, #34d399 0%, #10b981 100%); color: #064e3b; border: 2px solid #047857; box-shadow: 0 4px 12px -2px rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 700; min-width: 110px; justify-content: center; text-transform: capitalize; transition: all 0.3s ease;">
                                            Delivered
                                        </div>
                                    @elseif($statusLower === 'cancelled')
                                        <div style="background: linear-gradient(135deg, #f87171 0%, #ef4444 100%); color: #7f1d1d; border: 2px solid #dc2626; box-shadow: 0 4px 12px -2px rgba(239, 68, 68, 0.3); display: inline-flex; align-items: center; padding: 8px 18px; border-radius: 20px; font-size: 14px; font-weight: 700; min-width: 110px; justify-content: center; text-transform: capitalize; transition: all 0.3s ease;">
                                            Cancelled
                                        </div>
                                    @else
                                        <div style="background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%); color: #dc2626; padding: 6px 16px; border-radius: 16px; font-weight: 600; display: inline-flex; align-items: center; min-width: 100px; justify-content: center; font-size: 13px; border: 1px solid #f87171;">
                                            {{ ucfirst($order->status) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Enhanced Status Update Form -->
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex items-center space-x-3">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="text-sm border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-transparent min-w-[130px] bg-white">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 text-sm font-medium transform hover:scale-105 hover:shadow-lg focus:ring-4 focus:ring-indigo-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Inline Script untuk memastikan toggle buttons bekerja -->
            <script>
            // Pastikan ini dijalankan setelah tabel dimuat
            setTimeout(function() {
                console.log('🔄 Reinitializing toggle buttons...');
                
                const buttons = document.querySelectorAll('button[data-order-id]');
                console.log('Found', buttons.length, 'buttons to reinitialize');
                
                buttons.forEach(function(button) {
                    const orderId = button.getAttribute('data-order-id');
                    console.log('Reinitializing button for order:', orderId);
                    
                    // Remove any existing event listeners
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    
                    // Add fresh event listener with enhanced functionality
                    newButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('🖱️ Enhanced click for order:', orderId);
                        
                        const container = document.getElementById('order-products-' + orderId);
                        if (!container) {
                            console.error('Container not found:', 'order-products-' + orderId);
                            return;
                        }
                        
                        const isHidden = container.classList.contains('hidden');
                        const span = newButton.querySelector('span');
                        const icon = newButton.querySelector('svg');
                        
                        if (isHidden) {
                            // Show additional products
                            container.classList.remove('hidden');
                            container.style.display = 'block';
                            
                            // Update button for collapse state
                            if (span) span.textContent = 'Sembunyikan';
                            if (icon) icon.style.transform = 'rotate(180deg)';
                            
                            // Keep consistent teal/cyan gradient colors
                            // No color change to maintain consistency with other buttons
                            
                            console.log('✅ Additional products shown');
                        } else {
                            // Hide additional products
                            container.classList.add('hidden');
                            container.style.display = 'none';
                            
                            // Reset button for expand state
                            const itemCount = container.querySelectorAll('.product-item-card').length;
                            if (span) span.textContent = 'Lihat ' + itemCount + ' produk lainnya';
                            if (icon) icon.style.transform = 'rotate(0deg)';
                            
                            // Change button color back to teal
                            newButton.classList.remove('from-red-500', 'to-pink-500', 'hover:from-red-600', 'hover:to-pink-600');
                            newButton.classList.add('from-teal-500', 'to-cyan-500', 'hover:from-teal-600', 'hover:to-cyan-600');
                            
                            console.log('✅ Additional products hidden');
                        }
                    });
                });
                
                console.log('✅ All buttons reinitialized');
            }, 500);
            </script>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->withQueryString()->links('custom-pagination') }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan ditemukan</h3>
                <p class="text-gray-600">Coba ubah filter pencarian atau tunggu ada pesanan baru masuk</p>
            </div>
        @endif
    </div>
</div>
@endsection