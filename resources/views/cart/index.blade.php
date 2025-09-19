@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Keranjang Belanja</h1>

    @if(count($cartItems) > 0)
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">
                <tr>
                    <th class="py-4 px-6 text-left text-sm font-medium text-teal-800">Produk</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-teal-800">Harga</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-teal-800">Jumlah</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-teal-800">Total</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-teal-800">Aksi</th>
                </tr>
            </thead>
        <tbody>
            @foreach($cartItems as $id => $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-4 px-6">
                    <div class="flex items-center">
                        <img src="{{ asset('storage/' . $item['image_url']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                        <div class="ml-4">
                            <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6 text-center">
                    <span class="font-medium text-gray-800">Rp. {{ number_format($item['price'], 0, ',', '.') }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <button type="button" onclick="updateQuantity('{{ $id }}', -1)" class="w-8 h-8 bg-teal-100 text-teal-700 rounded-full hover:bg-teal-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <input type="number" id="qty-{{ $id }}" value="{{ $item['quantity'] }}" min="1" 
                               class="w-16 border border-gray-300 rounded-md py-1 px-2 text-center focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                               onchange="updateQuantityInput('{{ $id }}', this.value)"
                               data-price="{{ $item['price'] }}">
                        <button type="button" onclick="updateQuantity('{{ $id }}', 1)" class="w-8 h-8 bg-teal-100 text-teal-700 rounded-full hover:bg-teal-200 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>
                    </div>
                </td>
                <td class="py-4 px-6 text-center">
                    <span class="font-medium text-gray-800" id="item-total-{{ $id }}">Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                </td>
                <td class="py-4 px-6 text-center">
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded-md hover:bg-red-50 focus:ring-2 focus:ring-red-500 focus:ring-offset-2" title="Hapus dari keranjang">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-6 text-gray-800 border-b border-gray-200 pb-3">Ringkasan Pesanan</h2>
        <div class="space-y-4">
            <!-- Subtotal -->
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Subtotal ({{ count($cartItems) }} item):</span>
                <span class="font-medium text-gray-800" id="subtotal-display">Rp. {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            
            <!-- Ongkos Kirim -->
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Ongkos Kirim:</span>
                <span class="font-medium text-gray-800" id="shipping-cost">
                    @if($total >= 1000000)
                        <span class="text-green-600 font-semibold">GRATIS</span>
                    @else
                        Rp. 15.000
                    @endif
                </span>
            </div>
            
            <!-- Biaya Admin -->
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Biaya Admin:</span>
                <span class="font-medium text-gray-800" id="admin-fee">Rp. 2.000</span>
            </div>
            
            <!-- Pajak -->
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Pajak (1%):</span>
                <span class="font-medium text-gray-800" id="tax-amount">Rp. {{ number_format($total * 0.01, 0, ',', '.') }}</span>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center font-bold text-xl">
                    <span class="text-gray-800">Total Pembayaran:</span>
                    <span class="text-teal-600" id="final-total">
                        @php
                            $shippingCost = $total >= 1000000 ? 0 : 15000;
                            $adminFee = 2000;
                            $tax = $total * 0.01;
                            $finalTotal = $total + $shippingCost + $adminFee + $tax;
                        @endphp
                        Rp. {{ number_format($finalTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            <!-- Savings Info -->
            <div id="free-shipping-info" class="bg-green-50 border border-green-200 rounded-lg p-3 mt-4" style="display: {{ $total >= 1000000 ? 'block' : 'none' }}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-green-700 text-sm font-medium">Selamat! Anda mendapat gratis ongkir!</span>
                </div>
            </div>
            
            @if($total < 1000000)
            <div id="free-shipping-progress" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-700 text-sm font-medium">Belanja Rp. {{ number_format(1000000 - $total, 0, ',', '.') }} lagi untuk gratis ongkir!</span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($total / 1000000) * 100 }}%"></div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="mt-6">
            @auth
                <a href="{{ route('checkout.index') }}" class="block w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-center py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition duration-200 shadow-md hover:shadow-lg">
                    Lanjutkan ke Pembayaran
                </a>
            @else
                <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-center py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition duration-200 shadow-md hover:shadow-lg">
                    Masuk untuk Checkout
                </a>
            @endauth
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="bg-teal-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold mb-3 text-gray-800">Keranjang Anda Kosong</h2>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">Tambahkan beberapa produk ke keranjang Anda untuk melanjutkan berbelanja</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-8 py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition duration-200 shadow-md hover:shadow-lg">
            Lanjutkan Berbelanja
        </a>
    </div>
    @endif
</div>

<script>
// Variables for costs
const SHIPPING_COST = 15000;
const ADMIN_FEE = 2000;
const TAX_RATE = 0.01;
// Configuration
const FREE_SHIPPING_THRESHOLD = 1000000;

// Function to format currency
function formatCurrency(amount) {
    return 'Rp. ' + amount.toLocaleString('id-ID');
}

// Function to update quantity via buttons
function updateQuantity(productId, change) {
    const qtyInput = document.getElementById('qty-' + productId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = Math.max(1, currentQty + change);
    
    qtyInput.value = newQty;
    updateQuantityInput(productId, newQty);
}

// Function to update quantity via input
function updateQuantityInput(productId, quantity) {
    quantity = Math.max(1, parseInt(quantity));
    const qtyInput = document.getElementById('qty-' + productId);
    const price = parseFloat(qtyInput.dataset.price);
    
    // Update quantity input
    qtyInput.value = quantity;
    
    // Update item total display
    const itemTotal = price * quantity;
    document.getElementById('item-total-' + productId).textContent = formatCurrency(itemTotal);
    
    // Update summary
    updateCartSummary();
    
    // Send AJAX request to update cart
    updateCartOnServer(productId, quantity);
}

// Function to calculate and update cart summary
function updateCartSummary() {
    let subtotal = 0;
    
    // Calculate subtotal
    document.querySelectorAll('[id^="qty-"]').forEach(input => {
        const quantity = parseInt(input.value);
        const price = parseFloat(input.dataset.price);
        subtotal += price * quantity;
    });
    
    // Calculate costs
    const shippingCost = subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST;
    const taxAmount = subtotal * TAX_RATE;
    const finalTotal = subtotal + shippingCost + ADMIN_FEE + taxAmount;
    
    // Update displays
    document.getElementById('subtotal-display').textContent = formatCurrency(subtotal);
    const shippingElement = document.getElementById('shipping-cost');
    if (shippingCost === 0) {
        shippingElement.innerHTML = '<span class="text-green-600 font-semibold">GRATIS</span>';
    } else {
        shippingElement.textContent = formatCurrency(shippingCost);
    }
    document.getElementById('tax-amount').textContent = formatCurrency(taxAmount);
    document.getElementById('final-total').textContent = formatCurrency(finalTotal);
    
    // Update free shipping info
    const freeShippingInfo = document.getElementById('free-shipping-info');
    const freeShippingProgress = document.getElementById('free-shipping-progress');
    
    if (freeShippingInfo && freeShippingProgress) {
        if (subtotal >= FREE_SHIPPING_THRESHOLD) {
            freeShippingInfo.style.display = 'block';
            freeShippingProgress.style.display = 'none';
        } else {
            freeShippingInfo.style.display = 'none';
            freeShippingProgress.style.display = 'block';
            
            // Update progress bar
            const remaining = FREE_SHIPPING_THRESHOLD - subtotal;
            const progressPercentage = (subtotal / FREE_SHIPPING_THRESHOLD) * 100;
            
            const progressText = freeShippingProgress.querySelector('.text-blue-700');
            const progressBar = freeShippingProgress.querySelector('.bg-blue-600');
            
            if (progressText) {
                progressText.textContent = `Belanja ${formatCurrency(remaining).replace('Rp. ', 'Rp. ')} lagi untuk gratis ongkir!`;
            }
            if (progressBar) {
                progressBar.style.width = `${Math.min(progressPercentage, 100)}%`;
            }
        }
    }
}

// Function to update cart on server via AJAX
function updateCartOnServer(productId, quantity) {
    fetch(`/cart/update/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart badge in navbar if exists
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                cartBadge.textContent = data.cartCount;
            }
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
    });
}

// Initialize cart summary on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartSummary();
});
</script>

@endsection