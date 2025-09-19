@extends('layouts.app')

@section('title', 'Pesanan Berhasil - HealthHub')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-teal-50 flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 text-center max-w-2xl mx-auto">
        <!-- Success Icon -->
        <div class="text-green-500 mb-6">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-600 mb-6">Terima kasih telah berbelanja di HealthHub. Pesanan Anda sedang diproses.</p>
        
        <!-- Order Details -->
        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-6 rounded-xl mb-6 border border-teal-200">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-teal-100 p-3 rounded-full mr-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg text-teal-800">ID Pesanan: #{{ $order->id }}</p>
                    <p class="text-teal-600">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
            <p class="text-sm text-teal-700 bg-white/50 rounded-lg p-3">
                📧 Email konfirmasi telah dikirim ke <strong>{{ $order->user->email }}</strong>
            </p>
        </div>

        <!-- Auto Download Status -->
        <div id="download-status" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-center mb-2">
                <svg class="animate-spin w-5 h-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-blue-700 font-medium">Sedang mempersiapkan invoice...</span>
            </div>
            <div class="w-full bg-blue-200 rounded-full h-2">
                <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('report.invoice', $order) }}" 
               class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-teal-700 hover:to-cyan-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Invoice
            </a>
            <a href="{{ route('dashboard') }}" 
               class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:from-gray-200 hover:to-gray-300 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Ke Dashboard
            </a>
        </div>

        <!-- Info Footer -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                <span class="font-medium">Catatan:</span> Anda akan diarahkan ke dashboard dalam <span id="countdown">10</span> detik
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto download invoice
    let progress = 0;
    const progressBar = document.getElementById('progress-bar');
    const downloadStatus = document.getElementById('download-status');
    
    // Simulate progress
    const progressInterval = setInterval(() => {
        progress += 10;
        progressBar.style.width = progress + '%';
        
        if (progress >= 100) {
            clearInterval(progressInterval);
            
            // Trigger download
            setTimeout(() => {
                window.location.href = '{{ route("report.invoice", $order) }}';
                
                // Update status
                downloadStatus.innerHTML = `
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-green-700 font-medium">Invoice berhasil didownload!</span>
                    </div>
                `;
                downloadStatus.className = 'bg-green-50 border border-green-200 rounded-lg p-4 mb-6';
            }, 500);
        }
    }, 200);
    
    // Countdown redirect
    let countdown = 10;
    const countdownElement = document.getElementById('countdown');
    
    const countdownInterval = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
        
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            window.location.href = '{{ route("dashboard") }}';
        }
    }, 1000);
});
</script>
@endsection