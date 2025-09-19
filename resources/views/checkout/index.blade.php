@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b border-gray-200 pb-3">Informasi Pengiriman</h2>
                
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2" for="address">Alamat</label>
                        <textarea id="address" name="address" rows="3" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>{{ auth()->user()->address }}</textarea>
                    </div>
                
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="city">Kota</label>
                            <input type="text" id="city" name="city" value="{{ auth()->user()->city }}" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2" for="contact_no">Nomor Kontak</label>
                            <input type="text" id="contact_no" name="contact_no" value="{{ auth()->user()->contact_no }}" class="w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" required>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4 text-gray-800">Metode Pembayaran</h3>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                                <input type="radio" id="prepaid" name="payment_method" value="Prepaid" class="text-teal-600 focus:ring-teal-500 mr-3" checked>
                                <label for="prepaid" class="flex-1 cursor-pointer">
                                    <span class="font-medium">Bayar Dimuka (Prepaid)</span>
                                    <p class="text-sm text-gray-600">Pembayaran dilakukan sebelum pengiriman</p>
                                </label>
                            </div>
                            <div class="flex items-center p-3 border rounded-lg hover:bg-gray-50">
                                <input type="radio" id="postpaid" name="payment_method" value="Postpaid" class="text-teal-600 focus:ring-teal-500 mr-3">
                                <label for="postpaid" class="flex-1 cursor-pointer">
                                    <span class="font-medium">Bayar Belakangan (COD)</span>
                                    <p class="text-sm text-gray-600">Pembayaran saat barang diterima</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-4 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition duration-200 shadow-md hover:shadow-lg">
                        Buat Pesanan
                    </button>
            </form>
        </div>
    </div>
    
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b border-gray-200 pb-3">Ringkasan Pesanan</h2>
                
                <div class="space-y-4 mb-6">
                    @foreach($cartItems as $id => $item)
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                            <p class="text-gray-600 text-sm">Jumlah: {{ $item['quantity'] }}</p>
                        </div>
                        <span class="font-medium text-gray-800 ml-4">
                            Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach
                </div>
                
                <div class="border-t border-gray-200 pt-4 space-y-3">
                    <!-- Subtotal -->
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Subtotal ({{ count($cartItems) }} item):</span>
                        <span class="font-medium text-gray-800">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Ongkos Kirim -->
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Ongkos Kirim:</span>
                        <span class="font-medium text-gray-800">
                            @if($shippingCost == 0)
                                <span class="text-green-600 font-semibold">GRATIS</span>
                            @else
                                Rp. {{ number_format($shippingCost, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    
                    <!-- Biaya Admin -->
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Biaya Admin:</span>
                        <span class="font-medium text-gray-800">Rp. {{ number_format($adminFee, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Pajak -->
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pajak (1%):</span>
                        <span class="font-medium text-gray-800">Rp. {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Total Final -->
                    <div class="flex justify-between items-center font-bold text-lg pt-3 border-t border-gray-300">
                        <span class="text-gray-800">Total Pembayaran:</span>
                        <span class="text-teal-600">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Info Gratis Ongkir -->
                    @if($shippingCost == 0)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 mt-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-green-700 text-sm font-medium">Selamat! Anda mendapat gratis ongkir!</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($subtotal < 1000000)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-blue-700 text-sm font-medium">Belanja Rp. {{ number_format(1000000 - $subtotal, 0, ',', '.') }} lagi untuk gratis ongkir!</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($subtotal / 1000000) * 100 }}%"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
