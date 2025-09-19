@extends('layouts.app')

@section('title', 'Feedback Anda - HealthHub')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Feedback Anda</h1>
            <p class="text-gray-600">Terima kasih telah memberikan feedback untuk pesanan ini</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Order Info -->
            <div class="bg-gradient-to-r from-teal-600 to-cyan-600 p-6 text-white">
                <h2 class="text-xl font-semibold mb-2">Pesanan #{{ $order->id }}</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-teal-100">Tanggal Pesanan:</p>
                        <p class="font-medium">{{ $order->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-teal-100">Total:</p>
                        <p class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-4">Produk yang Dibeli:</h3>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">
                                    {{ $item->product ? $item->product->name : ($item->product_name ?? 'Produk tidak ditemukan') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $item->quantity }}x - Rp {{ number_format($item->price_per_item ?? ($item->product ? $item->product->price : 0), 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Feedback Display -->
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Feedback Anda</h3>
                
                <!-- Rating Display -->
                <div class="mb-6">
                    <p class="text-lg font-medium text-gray-900 mb-3">Rating:</p>
                    <div class="flex items-center space-x-3">
                        <div class="flex text-2xl">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $order->feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                            @endfor
                        </div>
                        <span class="text-lg font-semibold {{ $order->feedback->rating <= 2 ? 'text-red-600' : ($order->feedback->rating == 3 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $order->feedback->rating }}/5
                        </span>
                        <span class="text-sm text-gray-600">
                            @switch($order->feedback->rating)
                                @case(1) Sangat Buruk @break
                                @case(2) Buruk @break
                                @case(3) Cukup @break
                                @case(4) Baik @break
                                @case(5) Sangat Baik @break
                            @endswitch
                        </span>
                    </div>
                </div>

                <!-- Comment Display -->
                @if($order->feedback->comment)
                <div class="mb-6">
                    <p class="text-lg font-medium text-gray-900 mb-3">Komentar:</p>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-800 leading-relaxed">{{ $order->feedback->comment }}</p>
                    </div>
                </div>
                @endif

                <!-- Feedback Info -->
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-900">Feedback diberikan pada:</p>
                            <p class="text-sm text-blue-700">{{ $order->feedback->created_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="text-center">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection