@extends('layouts.app')

@section('title', 'Dashboard - HealthHub')
@section('description', 'Kelola pesanan, profil, dan pengaturan akun Anda di HealthHub.')

@push('styles')
<style>
    /* Custom scrollbar for order items */
    .order-items-scroll {
        scrollbar-width: thin;
        scrollbar-color: #14b8a6 #f1f5f9;
    }
    
    .order-items-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .order-items-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .order-items-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #14b8a6, #06b6d4);
        border-radius: 3px;
    }
    
    .order-items-scroll::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0f766e, #0891b2);
    }
    
    /* Smooth transitions for order items */
    .order-item-card {
        transition: all 0.2s ease-in-out;
    }
    
    .order-item-card:hover {
        transform: translateX(2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-8 mb-8 text-white">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat datang kembali, {{ Auth::user()->name }}!</h1>
            <p class="text-teal-100 text-lg">Kelola pesanan dan pengaturan akun Anda</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $validOrders->count() }}</p>
                    <p class="text-gray-600">Total Pesanan</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedOrders->count() }}</p>
                    <p class="text-gray-600">Selesai</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                    <p class="text-gray-600">Total Pengeluaran</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('products.index') }}" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-6 text-center group">
            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-teal-200 transition-colors duration-200">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Belanja Produk</h3>
            <p class="text-sm text-gray-600">Jelajahi peralatan medis</p>
        </a>

        <a href="{{ route('cart.index') }}" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-6 text-center group">
            <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-teal-200 transition-colors duration-200">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Lihat Keranjang</h3>
            <p class="text-sm text-gray-600">Tinjau item Anda</p>
        </a>

        <a href="{{ route('profile.edit') }}" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-6 text-center group">
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-cyan-200 transition-colors duration-200">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Edit Profil</h3>
            <p class="text-sm text-gray-600">Perbarui informasi Anda</p>
        </a>

        <a href="{{ route('shop-requests.index') }}" class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-6 text-center group">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-orange-200 transition-colors duration-200">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Permohonan Toko</h3>
            <p class="text-sm text-gray-600">Ajukan toko baru</p>
        </a>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
        </div>

        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @if($order->orderItems->count() > 0)
                                        <div class="max-h-40 overflow-y-auto space-y-2 pr-2 order-items-scroll">
                                            @foreach($order->orderItems as $item)
                                                <div class="flex items-start py-1.5 px-2 bg-gray-50 rounded-lg order-item-card">
                                                    <span class="inline-flex items-center justify-center w-8 h-6 rounded-full text-xs font-bold bg-gradient-to-r from-teal-500 to-cyan-500 text-white mr-3 flex-shrink-0 mt-0.5">
                                                        {{ $item->quantity }}x
                                                    </span>
                                                    <div class="flex-1 min-w-0">
                                                        <span class="font-medium text-gray-800 text-sm leading-tight block truncate" title="{{ $item->product ? $item->product->name : ($item->product_name ?? 'Produk tidak ditemukan') }}">
                                                            {{ $item->product ? $item->product->name : ($item->product_name ?? 'Produk tidak ditemukan') }}
                                                        </span>
                                                        @if($item->product && $item->product->price)
                                                            <span class="text-xs text-gray-500 block mt-0.5">
                                                                Rp {{ number_format($item->price_per_item ?? $item->product->price, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-200">
                                            <span class="text-xs text-gray-500 font-medium">
                                                {{ $order->orderItems->count() }} jenis produk
                                            </span>
                                            <span class="text-xs text-teal-600 font-semibold">
                                                {{ $order->orderItems->sum('quantity') }} total item
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-gray-500 italic">Tidak ada produk</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Processing' => 'bg-blue-100 text-blue-800',
                                        'Shipped' => 'bg-purple-100 text-purple-800',
                                        'Delivered' => 'bg-green-100 text-green-800',
                                        'Completed' => 'bg-green-100 text-green-800',
                                        'Cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    
                                    $statusTranslations = [
                                        'Pending' => 'Menunggu',
                                        'Processing' => 'Diproses',
                                        'Shipped' => 'Dikirim',
                                        'Delivered' => 'Diterima',
                                        'Completed' => 'Selesai',
                                        'Cancelled' => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusTranslations[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($order->canReceiveFeedback())
                                        <a href="{{ route('feedback.create', $order) }}" 
                                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            Beri Feedback
                                        </a>
                                    @elseif($order->hasFeedback())
                                        <a href="{{ route('feedback.show', $order) }}" 
                                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Feedback
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('report.invoice', $order) }}" 
                                       class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Invoice
                                    </a>

                                    @if($order->status === 'Pending')
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to cancel this order?')"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No orders yet</h3>
                <p class="text-gray-600 mb-6">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection