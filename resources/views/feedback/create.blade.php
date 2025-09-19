@extends('layouts.app')

@section('title', 'Beri Feedback - HealthHub')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Beri Feedback</h1>
            <p class="text-gray-600">Bagikan pengalaman Anda dengan pesanan ini</p>
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

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('feedback.store', $order->id) }}" method="POST" class="space-y-6">
            @csrf

                    <!-- Rating -->
                    <div>
                        <label class="block text-lg font-semibold text-gray-900 mb-4">
                            Berikan Rating <span class="text-red-500">*</span>
                        </label>
                        <div class="flex justify-center items-center space-x-2 mb-4">
                            <div class="flex flex-row-reverse justify-center gap-1 text-3xl cursor-pointer star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                           class="hidden peer peer-star{{ $i }}" required>
                                    <label for="star{{ $i }}" 
                                           class="star text-gray-300 hover:text-yellow-400 peer-checked:text-yellow-500 transition-colors duration-200 select-none">
                                        ★
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div class="text-center">
                            <span id="rating-text" class="text-sm text-gray-600 font-medium"></span>
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-lg font-semibold text-gray-900 mb-3">
                            Komentar & Saran
                        </label>
                        <textarea name="comment" id="comment" rows="5" 
                                  placeholder="Bagikan pengalaman Anda dengan produk dan layanan kami..."
                                  class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 resize-none">{{ old('comment') }}</textarea>
                        <p class="text-sm text-gray-500 mt-2">Maksimal 1000 karakter</p>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-4 pt-4">
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starInputs = document.querySelectorAll('input[name="rating"]');
    const ratingText = document.getElementById('rating-text');
    
    const ratingLabels = {
        1: 'Sangat Buruk - Tidak puas sama sekali',
        2: 'Buruk - Kurang memuaskan',
        3: 'Cukup - Sesuai ekspektasi',
        4: 'Baik - Memuaskan',
        5: 'Sangat Baik - Sangat puas!'
    };
    
    starInputs.forEach(input => {
        input.addEventListener('change', function() {
            const rating = this.value;
            ratingText.textContent = ratingLabels[rating];
            ratingText.className = `text-sm font-medium mt-2 ${
                rating <= 2 ? 'text-red-600' : 
                rating == 3 ? 'text-yellow-600' : 
                'text-green-600'
            }`;
        });
    });
    
    // Star hover effect
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', function() {
            const starIndex = 5 - index; // reverse index
            stars.forEach((s, i) => {
                if (5 - i <= starIndex) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
    
    // Reset on mouse leave
    document.querySelector('.star-rating').addEventListener('mouseleave', function() {
        const checkedInput = document.querySelector('input[name="rating"]:checked');
        stars.forEach((s, i) => {
            s.classList.remove('text-yellow-400');
            s.classList.add('text-gray-300');
            
            if (checkedInput && 5 - i <= parseInt(checkedInput.value)) {
                s.classList.remove('text-gray-300');
                s.classList.add('text-yellow-500');
            }
        });
    });
});
</script>
@endpush

@endsection
