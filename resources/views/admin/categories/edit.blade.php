@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-cyan-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                                Edit Kategori
                            </h1>
                            <p class="text-gray-600 mt-1">Perbarui informasi kategori "{{ $category->name }}"</p>
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

        {{-- Current Category Info --}}
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                <h3 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Kategori Saat Ini
                </h3>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">{{ strtoupper(substr($category->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-blue-900">{{ $category->name }}</div>
                        <div class="text-sm text-blue-600">Slug: {{ $category->slug }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            {{-- Form Header --}}
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-8 py-6">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Update Informasi Kategori
                </h2>
                <p class="text-orange-100 mt-1">Modifikasi detail kategori produk kesehatan</p>
            </div>

            {{-- Form Content --}}
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-8">
                @csrf 
                @method('PUT')

                {{-- Input Section --}}
                <div class="space-y-8">
                    {{-- Nama Kategori --}}
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Nama Kategori
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   class="w-full px-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 hover:border-amber-400 bg-gray-50 focus:bg-white @error('name') border-red-500 focus:border-red-500 focus:ring-red-100 @enderror"
                                   placeholder="Contoh: Furnitur Medis, Peralatan Diagnostik, dll."
                                   required 
                                   value="{{ old('name', $category->name) }}"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            Perubahan akan memperbarui semua referensi kategori ini
                        </p>
                    </div>

                    {{-- Preview Section --}}
                    {{-- <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                        <h3 class="text-lg font-semibold text-amber-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview Kategori Baru
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-lg" id="category-preview">{{ strtoupper(substr($category->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-amber-900" id="category-name-preview">{{ $category->name }}</div>
                                <div class="text-sm text-amber-600">Kategori Produk Kesehatan (Updated)</div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- Change History --}}
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Perubahan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2M8 7v10a2 2 0 002 2h4a2 2 0 002-2V7"/>
                                </svg>
                                Dibuat: {{ $category->created_at->format('d M Y, H:i') }}
                            </div>
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Terakhir diubah: {{ $category->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
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
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:ring-4 focus:ring-amber-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Update Kategori
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
            categoryNamePreview.textContent = '{{ $category->name }}';
            categoryPreview.textContent = '{{ strtoupper(substr($category->name, 0, 2)) }}';
        }
    });
});
</script>
@endpush

{{-- Custom Styles --}}
@push('styles')
<style>
    .group:hover .group-hover\:text-amber-500 {
        color: #f59e0b;
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
        
        .grid.grid-cols-1.md\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@endsection
