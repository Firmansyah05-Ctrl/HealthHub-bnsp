@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Edit Profil</h2>

        @if(session('success'))
        <div class="mb-6 bg-teal-100 border border-teal-200 text-teal-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                {{-- Name --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Date of Birth --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                {{-- Gender --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                    <select name="gender" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        <option value="">--Pilih Jenis Kelamin--</option>
                        <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Perempuan</option>
                        <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                {{-- Address --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Alamat</label>
                    <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">{{ old('address', $user->address) }}</textarea>
                </div>

                {{-- City --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Kota</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                {{-- Contact No --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Nomor Kontak</label>
                    <input type="text" name="contact_no" value="{{ old('contact_no', $user->contact_no) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                {{-- Paypal ID --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">PayPal ID</label>
                    <input type="text" name="paypal_id" value="{{ old('paypal_id', $user->paypal_id) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 mb-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500" placeholder="Masukkan kata sandi baru">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-3 rounded-lg font-medium hover:from-teal-700 hover:to-cyan-700 transition duration-200 shadow-md hover:shadow-lg">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
    </form>
</div>
@endsection
