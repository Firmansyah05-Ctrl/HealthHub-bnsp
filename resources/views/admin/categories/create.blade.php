@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-cyan-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                Tambah Kategori Baru
                            </h1>
                            <p class="text-gray-600 mt-1">Buat kategori baru untuk produk kesehatan</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.categories.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl hover:from-gray-600 hover:to-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Form Header --}}
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Informasi Kategori
                </h2>
                <p class="text-green-100 mt-1">Masukkan detail kategori produk kesehatan</p>
            </div>

            {{-- Form Content --}}
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-8">
                @csrf

                {{-- Input Section --}}
                <div class="space-y-8">
                    {{-- Nama Kategori --}}
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Nama Kategori
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 hover:border-green-400 bg-gray-50 focus:bg-white @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                                   placeholder="Contoh: Furnitur Medis, Peralatan Diagnostik, dll."
                                   required 
                                   value="{{ old('name') }}"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        </div>
                        @error('name')
                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-xl flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-sm text-red-600 font-medium">{{ $message }}</p>
                            </div>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nama kategori akan digunakan untuk mengelompokkan produk kesehatan
                        </p>
                    </div>

                    {{-- Preview Section --}}
                    {{-- <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                        <h3 class="text-lg font-semibold text-green-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview Kategori
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg" id="category-preview">?</span>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-green-900" id="category-name-preview">Nama Kategori</div>
                                <div class="text-sm text-green-600">Kategori Produk Kesehatan</div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                {{-- Action Buttons --}}
                <div class="mt-10 flex items-center justify-between bg-gray-50 -m-8 mt-8 p-8 rounded-b-2xl">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-500">*</span> Field wajib diisi
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:ring-4 focus:ring-green-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for Live Preview --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const categoryPreview = document.getElementById('category-preview');
    const categoryNamePreview = document.getElementById('category-name-preview');
    
    nameInput.addEventListener('input', function() {
        const value = this.value.trim();
        
        if (value) {
            // Update preview text
            categoryNamePreview.textContent = value;
            
            // Update avatar with first 2 characters
            const initials = value.substring(0, 2).toUpperCase();
            categoryPreview.textContent = initials;
        } else {
            categoryNamePreview.textContent = 'Nama Kategori';
            categoryPreview.textContent = '?';
        }
    });
});
</script>
@endpush

{{-- Custom Styles --}}
@push('styles')
<style>
    .group:hover .group-hover\:text-green-500 {
        color: #10b981;
    }
    
    @media (max-width: 768px) {
        .flex.items-center.justify-between {
            flex-direction: column;
            gap: 1rem;
        }
        
        .flex.items-center.space-x-4:last-child {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@endsection
