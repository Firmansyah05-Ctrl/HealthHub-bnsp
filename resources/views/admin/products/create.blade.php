@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" 
          class="space-y-5 bg-white p-6 rounded-lg shadow">
        @csrf

        {{-- Nama Produk --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                   required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi Produk --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
    <textarea name="description" id="description" rows="4"
              class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('description') }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


        {{-- Kategori --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category_id" id="category_id" 
                    class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                    required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Harga --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                   required>
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stok --}}
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                   class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                   required>
            @error('stock')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gambar --}}
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
            <input type="file" name="image" id="image"
                   class="w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-3">
            <button type="submit" 
                    class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                Simpan
            </button>
            <a href="{{ route('admin.products.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
