@extends('layouts.app')

@section('title', 'Ajukan Toko Baru - HealthHub')
@section('description', 'Ajukan permohonan untuk membuka toko baru di platform HealthHub.')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-8 mb-8 text-white">
                <div class="flex items-center">
                    {{-- <div class="hidden md:block">
                        <svg class="w-16 h-16 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div> --}}
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Ajukan Toko Baru</h1>
                        <p class="text-teal-100">Bergabunglah sebagai mitra penjual peralatan medis</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">Terdapat kesalahan dalam pengisian form:</span>
                        </div>
                        <ul class="list-disc list-inside ml-7 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('shop-requests.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="shop_name" class="block text-gray-700 font-medium mb-2">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                            placeholder="Masukkan nama toko yang diinginkan" required>
                        <p class="text-sm text-gray-600 mt-2">Nama toko akan ditampilkan kepada pelanggan dan harus unik.
                        </p>
                    </div>

                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-teal-600 mr-3 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-medium text-teal-800 mb-1">Informasi Penting</h4>
                                <p class="text-sm text-teal-700">
                                    Setelah mengirimkan permohonan, tim kami akan meninjau aplikasi Anda dalam 1-3 hari
                                    kerja.
                                    Anda akan menerima notifikasi melalui email mengenai status permohonan Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('shop-requests.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition duration-200">
                            Kembali
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-medium rounded-lg shadow-md hover:from-teal-700 hover:to-cyan-700 transition duration-200">
                            Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
