@extends('layouts.app')

@section('title', 'Edit Produk - Admin HealthHub')
@section('description', 'Edit produk alat kesehatan di HealthHub dengan interface modern.')

@push('styles')
<style>
    .form-container {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        transition: all 0.3s ease;
    }
    
    .form-container:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    .input-field {
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .input-field:focus {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(20, 184, 166, 0.1);
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    }
    
    .preview-image {
        transition: all 0.3s ease;
    }
    
    .preview-image:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    /* Enhanced animations */
    .field-group {
        opacity: 0;
        transform: translateY(20px);
        animation: slideInUp 0.5s ease-out forwards;
    }
    
    .field-group:nth-child(1) { animation-delay: 0.1s; }
    .field-group:nth-child(2) { animation-delay: 0.2s; }
    .field-group:nth-child(3) { animation-delay: 0.3s; }
    .field-group:nth-child(4) { animation-delay: 0.4s; }
    .field-group:nth-child(5) { animation-delay: 0.5s; }
    .field-group:nth-child(6) { animation-delay: 0.6s; }
    
    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Floating labels effect */
    .floating-label {
        position: relative;
    }
    
    .floating-label input:focus + label,
    .floating-label input:not(:placeholder-shown) + label,
    .floating-label textarea:focus + label,
    .floating-label textarea:not(:placeholder-shown) + label {
        transform: translateY(-1.5rem) scale(0.85);
        color: #14b8a6;
    }
    
    /* Custom scrollbar for description textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #14b8a6;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #0d9488;
    }
    
    /* Success notification styles */
    .success-glow {
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
        animation: successPulse 1s ease-out;
    }
    
    @keyframes successPulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    
    /* Simplified input styling */
    .input-field {
        transition: all 0.2s ease;
    }
    
    .input-field:focus {
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }
    
    /* Better mobile responsiveness */
    @media (max-width: 640px) {
        .form-container {
            margin: 1rem;
            border-radius: 1.5rem;
        }
        
        .grid.grid-cols-1.lg\\:grid-cols-2 {
            gap: 1.5rem;
        }
        
        .px-8 {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 gradient-bg rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                        Edit Produk
                    </h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi produk alat kesehatan</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ now()->format('d M Y, H:i') }} WIB</span>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-100 gradient-bg">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <h2 class="text-xl font-bold text-white">{{ $product->name }}</h2>
            </div>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" 
              class="p-8 space-y-8">
        @csrf
        @method('PUT')

            {{-- Nama Produk --}}
            <div class="field-group space-y-3">
                <label for="name" class="flex items-center text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Nama Produk
                    <span class="text-red-500 ml-1">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                       class="w-full px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-base placeholder-gray-400 bg-gray-50 hover:bg-white transition-all duration-200"
                       placeholder="Masukkan nama produk alat kesehatan..."
                       maxlength="255"
                       required>
                @error('name')
                    <div class="flex items-center mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            {{-- Deskripsi Produk --}}
            <div class="field-group space-y-3">
                <label for="description" class="flex items-center text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                    Deskripsi Produk
                </label>
                <div class="space-y-2">
                    <textarea name="description" id="description" rows="5"
                              class="w-full px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-base placeholder-gray-400 bg-gray-50 hover:bg-white resize-none transition-all duration-200"
                              placeholder="Jelaskan detail produk, spesifikasi, dan kegunaan alat kesehatan ini..."
                              maxlength="1000">{{ old('description', $product->description) }}</textarea>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>💡 Deskripsikan dengan detail untuk membantu customer memahami produk</span>
                        <span><span id="charCount">{{ strlen($product->description ?? '') }}</span>/1000 karakter</span>
                    </div>
                </div>
                @error('description')
                    <div class="flex items-center mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>


            {{-- Kategori --}}
            <div class="field-group space-y-3">
                <label for="category_id" class="flex items-center text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori Produk
                    <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="relative">
                    <select name="category_id" id="category_id" 
                            class="w-full px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-base bg-gray-50 hover:bg-white appearance-none transition-all duration-200"
                            required>
                        <option value="">🏥 Pilih Kategori Alat Kesehatan</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
                @error('category_id')
                    <div class="flex items-center mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            {{-- Row untuk Harga dan Stok --}}
            <div class="field-group grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Harga --}}
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <label for="price" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        Harga Produk
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-500">Rp</span>
                            <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}"
                                   class="flex-1 px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-base placeholder-gray-400 bg-gray-50 hover:bg-white transition-all duration-200"
                                   placeholder="25000000"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   required>
                        </div>
                        <div id="priceFormatted" class="text-sm text-teal-600 font-medium min-h-[20px]"></div>
                    </div>
                    <div class="mt-3">
                        <p class="text-xs text-gray-500">
                            � Masukkan harga dalam rupiah tanpa titik atau koma
                        </p>
                    </div>
                    @error('price')
                        <div class="flex items-center mt-3 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                    <label for="stock" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                        <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Jumlah Stok
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                                   class="flex-1 px-3 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-base placeholder-gray-400 bg-gray-50 hover:bg-white transition-all duration-200"
                                   placeholder="84"
                                   pattern="[0-9]*"
                                   inputmode="numeric"
                                   maxlength="4"
                                   required>
                            <span class="text-sm font-medium text-gray-500">unit</span>
                        </div>
                        {{-- <div class="flex items-center space-x-2">
                            <div id="stockStatus" class="w-3 h-3 rounded-full bg-gray-300"></div>
                            <span id="stockLabel" class="text-sm text-gray-500 font-medium">Status Stok</span>
                            <span id="stockUnit" class="text-sm text-gray-400">({{ $product->stock }} unit)</span>
                        </div> --}}
                    </div>
                    <div class="mt-3">
                        <p class="text-xs text-gray-500">
                            📦 Masukkan jumlah unit yang tersedia untuk dijual (maksimal 9999)
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            • >10: Tersedia • 1-10: Terbatas • 0: Habis
                        </p>
                    </div>
                    @error('stock')
                        <div class="flex items-center mt-3 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Gambar Produk --}}
            <div class="field-group space-y-4">
                <label for="image" class="flex items-center text-sm font-semibold text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Gambar Produk
                </label>
                
                {{-- Current Image Preview --}}
                @if($product->image_url)
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-600 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Gambar Saat Ini:
                        </p>
                        <div class="relative group inline-block">
                            <img src="{{ Storage::url($product->image_url) }}" 
                                 alt="{{ $product->name }}" 
                                 class="preview-image w-48 h-48 object-cover rounded-xl border-2 border-gray-200 shadow-lg"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjI0IiBoZWlnaHQ9IjI0IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xMiA5VjE0TTEyIDE3SDE2TTggMTdIMTJNMTIgOVY3TTEyIDdIMTZNOCA3SDEyIiBzdHJva2U9IiM5Q0EzQUYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo='; this.className='w-48 h-48 object-cover rounded-xl border-2 border-gray-200 shadow-lg bg-gray-100 flex items-center justify-center';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 rounded-xl transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1 text-xs font-medium text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Gambar Produk
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Upload New Image --}}
                <div class="space-y-3">
                    <p class="text-sm font-medium text-gray-600 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        {{ $product->image_url ? 'Upload Gambar Baru:' : 'Upload Gambar:' }}
                    </p>
                    
                    <div class="relative">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gradient-to-br from-gray-50 to-gray-100 hover:from-teal-50 hover:to-cyan-50 hover:border-teal-300 transition-all duration-200 group">
                            <div class="flex flex-col items-center justify-center pt-4 pb-4" id="uploadPlaceholder">
                                <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-teal-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-1 text-sm text-gray-500 group-hover:text-teal-600 transition-colors duration-200">
                                    <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                </p>
                                <p class="text-xs text-gray-400">PNG, JPG, JPEG atau WEBP (Max. 2MB)</p>
                            </div>
                            
                            <!-- Preview area for new image -->
                            <div id="imagePreview" class="hidden w-full h-full">
                                <img id="previewImg" class="w-full h-full object-cover rounded-lg" alt="Preview">
                                <div class="absolute top-2 right-2">
                                    <button type="button" onclick="clearImagePreview()" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-1 text-xs transition-colors duration-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </label>
                        <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                    
                    @if($product->image_url)
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-yellow-700">
                                    Kosongkan jika tidak ingin mengganti gambar yang sudah ada
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                @error('image')
                    <div class="flex items-center mt-2 text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg p-3">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="field-group flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-6 border-t border-gray-100">
                <button type="submit" id="submitButton"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-teal-700 hover:to-cyan-700 focus:ring-4 focus:ring-teal-200 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <span id="submitText">Update Produk</span>
                </button>
                
                <a href="{{ route('admin.products.index') }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 focus:ring-4 focus:ring-gray-200 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </form>
    </div>

    {{-- Quick Actions Footer --}}
    <div class="mt-8 flex flex-wrap items-center justify-center gap-4 text-sm text-gray-500">
        <div class="flex items-center space-x-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Tips: Pastikan informasi produk lengkap dan akurat</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Data akan disimpan secara otomatis setelah update</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character counter for description
    document.getElementById('description').addEventListener('input', function() {
        const current = this.value.length;
        const max = 1000;
        const counter = document.getElementById('charCount');
        counter.textContent = current;
        
        // Change color based on length  
        const counterContainer = counter.parentElement.parentElement;
        if (current > max * 0.9) {
            counterContainer.classList.add('text-red-500');
            counterContainer.classList.remove('text-gray-500', 'text-yellow-500');
        } else if (current > max * 0.7) {
            counterContainer.classList.add('text-yellow-500');
            counterContainer.classList.remove('text-gray-500', 'text-red-500');
        } else {
            counterContainer.classList.add('text-gray-500');
            counterContainer.classList.remove('text-red-500', 'text-yellow-500');
        }
    });
    
    // Auto-format price input with real-time formatting
    document.getElementById('price').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value === '') {
            e.target.value = '';
            document.getElementById('priceFormatted').textContent = '';
            return;
        }
        
        // Remove leading zeros
        value = value.replace(/^0+/, '') || '0';
        
        // Limit maximum value to prevent overflow
        if (parseInt(value) > 999999999) {
            value = '999999999';
        }
        
        e.target.value = value;
        
        // Update formatted price display
        const formatted = value && value !== '0' ? 'Format: Rp ' + parseInt(value).toLocaleString('id-ID') : '';
        document.getElementById('priceFormatted').textContent = formatted;
    });
    
    // Handle focus event to select all text for easy editing
    document.getElementById('price').addEventListener('focus', function(e) {
        e.target.select();
    });
    
    // Stock status indicator
    function updateStockStatus() {
        const stockValue = parseInt(document.getElementById('stock').value) || 0;
        const statusIndicator = document.getElementById('stockStatus');
        const statusLabel = document.getElementById('stockLabel');
        const stockUnit = document.getElementById('stockUnit');
        
        // Update unit display
        if (stockUnit) {
            stockUnit.textContent = `(${stockValue} unit)`;
        }
        
        if (stockValue === 0) {
            // Stok Habis (Red)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-red-500';
            statusLabel.className = 'text-sm text-red-600 font-medium';
            statusLabel.textContent = 'Stok Habis';
        } else if (stockValue <= 10) {
            // Stok Terbatas (Yellow)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-500';
            statusLabel.className = 'text-sm text-yellow-600 font-medium';
            statusLabel.textContent = 'Stok Terbatas';
        } else {
            // Stok Tersedia (Green)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
            statusLabel.className = 'text-sm text-green-600 font-medium';
            statusLabel.textContent = 'Stok Tersedia';
        }
    }
    
    // Stock input validation and formatting
    document.getElementById('stock').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value === '') {
            e.target.value = '';
            updateStockStatus();
            return;
        }
        
        // Remove leading zeros but keep single zero
        value = value.replace(/^0+/, '') || '0';
        
        // Limit to 4 digits (0-9999)
        if (parseInt(value) > 9999) {
            value = '9999';
        }
        
        e.target.value = value;
        updateStockStatus();
    });
    
    // Handle focus event to select all text for easy editing
    document.getElementById('stock').addEventListener('focus', function(e) {
        e.target.select();
    });
    
    // Stock status update function
    function updateStockStatus() {
        const stockInput = document.getElementById('stock');
        const stockValue = parseInt(stockInput.value) || 0;
        const statusIndicator = document.getElementById('stockStatus');
        const statusLabel = document.getElementById('stockLabel');
        const stockUnit = document.getElementById('stockUnit');
        
        // Update unit display
        stockUnit.textContent = `(${stockValue} unit)`;
        
        if (stockValue > 10) {
            // Stok Tersedia (Green)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-green-500';
            statusLabel.className = 'text-sm text-green-600 font-medium';
            statusLabel.textContent = 'Stok Tersedia';
        } else if (stockValue > 0) {
            // Stok Terbatas (Yellow)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-yellow-500';
            statusLabel.className = 'text-sm text-yellow-600 font-medium';
            statusLabel.textContent = 'Stok Terbatas';
        } else {
            // Stok Habis (Red)
            statusIndicator.className = 'w-3 h-3 rounded-full bg-red-500';
            statusLabel.className = 'text-sm text-red-600 font-medium';
            statusLabel.textContent = 'Stok Habis';
        }
    }
    
    // Initialize price formatting and stock status on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Format initial price - clean and format the value
        const priceInput = document.getElementById('price');
        if (priceInput.value) {
            // Clean the value to numbers only
            let cleanValue = priceInput.value.replace(/\D/g, '');
            priceInput.value = cleanValue;
            
            // Update formatted display
            if (cleanValue) {
                const formatted = 'Format: Rp ' + parseInt(cleanValue).toLocaleString('id-ID');
                document.getElementById('priceFormatted').textContent = formatted;
            }
        }
        
        // Set initial stock status
        const stockInput = document.getElementById('stock');
        if (stockInput.value) {
            // Clean stock value to numbers only
            let cleanStockValue = stockInput.value.replace(/\D/g, '');
            stockInput.value = cleanStockValue;
        }
        
        // Always update stock status on page load
        updateStockStatus();
    });
    
    // Image preview functionality
    function previewImage(input) {
        const file = input.files[0];
        const placeholder = document.getElementById('uploadPlaceholder');
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (file) {
            // Validate file type
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Tipe file tidak didukung. Pilih file PNG, JPG, JPEG, atau WEBP.');
                input.value = '';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                input.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            clearImagePreview();
        }
    }
    
    // Clear image preview
    function clearImagePreview() {
        const placeholder = document.getElementById('uploadPlaceholder');
        const preview = document.getElementById('imagePreview');
        const input = document.getElementById('image');
        
        placeholder.classList.remove('hidden');
        preview.classList.add('hidden');
        input.value = '';
    }
    
    // Drag and drop functionality
    const uploadArea = document.querySelector('label[for="image"]');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        uploadArea.classList.add('border-teal-400', 'bg-teal-50');
    }
    
    function unhighlight(e) {
        uploadArea.classList.remove('border-teal-400', 'bg-teal-50');
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            document.getElementById('image').files = files;
            previewImage(document.getElementById('image'));
        }
    }
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();
        const stock = document.getElementById('stock').value.trim();
        const category = document.getElementById('category_id').value;
        
        if (!name || !price || !stock || !category) {
            e.preventDefault();
            showToast('Mohon lengkapi semua field yang wajib diisi.', 'error');
            return false;
        }
        
        const priceValue = parseInt(price.replace(/\D/g, ''));
        const stockValue = parseInt(stock.replace(/\D/g, ''));
        
        if (isNaN(priceValue) || priceValue <= 0) {
            e.preventDefault();
            showToast('Harga harus berupa angka positif.', 'error');
            return false;
        }
        
        if (isNaN(stockValue) || stockValue < 0) {
            e.preventDefault();
            showToast('Stok harus berupa angka yang valid (0 atau lebih).', 'error');
            return false;
        }
        
        // Show loading state
        const submitBtn = document.getElementById('submitButton');
        const submitText = document.getElementById('submitText');
        const originalText = submitText.textContent;
        
        submitBtn.disabled = true;
        submitText.textContent = 'Memperbarui...';
        
        // Add loading spinner
        const spinner = document.createElement('svg');
        spinner.className = 'animate-spin w-5 h-5 mr-2';
        spinner.setAttribute('fill', 'none');
        spinner.setAttribute('viewBox', '0 0 24 24');
        spinner.innerHTML = `
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        `;
        
        submitBtn.replaceChild(spinner, submitBtn.firstElementChild);
        
        // Reset button if form submission fails (timeout after 10 seconds)
        setTimeout(() => {
            if (submitBtn.disabled) {
                submitBtn.disabled = false;
                submitText.textContent = originalText;
                // Restore original icon
                const originalIcon = document.createElement('svg');
                originalIcon.className = 'w-5 h-5 mr-2';
                originalIcon.setAttribute('fill', 'none');
                originalIcon.setAttribute('stroke', 'currentColor');
                originalIcon.setAttribute('viewBox', '0 0 24 24');
                originalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>';
                submitBtn.replaceChild(originalIcon, submitBtn.firstElementChild);
            }
        }, 10000);
    });
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 max-w-sm p-4 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full`;
        
        if (type === 'error') {
            toast.classList.add('bg-red-500');
        } else if (type === 'success') {
            toast.classList.add('bg-green-500');
        } else {
            toast.classList.add('bg-blue-500');
        }
        
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'error' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                    }
                </svg>
                <span class="text-sm font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 4000);
    }
</script>
@endpush

@endsection
