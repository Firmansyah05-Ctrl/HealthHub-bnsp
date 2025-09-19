@extends('layouts.app')

@section('title', 'Permohonan Toko - HealthHub')
@section('description', 'Kelola dan pantau status permohonan toko Anda di HealthHub.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Permohonan Toko Saya</h1>
                <p class="text-teal-100">Pantau status permohonan dan ajukan toko baru</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Action Button -->
    <div class="mb-8">
        <a href="{{ route('shop-requests.create') }}"
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-medium rounded-lg shadow-md hover:from-teal-700 hover:to-cyan-700 transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Ajukan Toko Baru
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Riwayat Permohonan</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-teal-50 to-cyan-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Nama Toko</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-teal-800 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-teal-800 uppercase tracking-wider">Tanggal Pengajuan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $req)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $req->shop_name }}</div>
                                        <div class="text-sm text-gray-500">ID: #{{ $req->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'pending' => ['text' => 'Menunggu Persetujuan', 'class' => 'bg-yellow-100 text-yellow-800'],
                                        'approved' => ['text' => 'Disetujui', 'class' => 'bg-green-100 text-green-800'],
                                        'rejected' => ['text' => 'Ditolak', 'class' => 'bg-red-100 text-red-800']
                                    ];
                                    $config = $statusConfig[$req->status] ?? ['text' => $req->status, 'class' => 'bg-gray-100 text-gray-800'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $config['class'] }}">
                                    {{ $config['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm text-gray-900">{{ $req->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $req->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada permohonan toko</h3>
                                    <p class="text-gray-500 mb-4">Mulai dengan mengajukan toko baru untuk menjadi mitra penjual kami.</p>
                                    <a href="{{ route('shop-requests.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-sm font-medium rounded-lg hover:from-teal-700 hover:to-cyan-700 transition duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Ajukan Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
        </table>
    </div>
</div>
@endsection
