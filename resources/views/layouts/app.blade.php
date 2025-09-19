<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HealthHub - Perlengkapan Medis Profesional')</title>
    <meta name="description" content="@yield('description', 'Perlengkapan medis premium dan perlengkapan untuk tenaga kesehatan profesional. Produk berkualitas dengan pengiriman cepat.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
    
    <!-- Custom Toast Styles -->
    <style>
        /* Toast Animation Keyframes */
        @keyframes toastSlideIn {
            from {
                transform: translateX(100%) scale(0.9);
                opacity: 0;
            }
            to {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }
        
        @keyframes toastSlideOut {
            from {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
            to {
                transform: translateX(100%) scale(0.9);
                opacity: 0;
            }
        }
        
        @keyframes toastBounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-4px);
            }
            60% {
                transform: translateY(-2px);
            }
        }
        
        /* Toast Container */
        .toast-container {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            pointer-events: none;
        }
        
        .toast-item {
            pointer-events: auto;
            animation: toastSlideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .toast-item.bouncing {
            animation: toastBounce 0.6s ease-in-out;
        }
        
        .toast-item.closing {
            animation: toastSlideOut 0.3s ease-in-out forwards;
        }
        
        /* Enhanced backdrop blur for modern look */
        .toast-backdrop {
            backdrop-filter: blur(12px) saturate(1.5);
            -webkit-backdrop-filter: blur(12px) saturate(1.5);
        }
        
        /* Subtle shadow for depth */
        .toast-shadow {
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
        }
        
        /* Smooth icon rotation */
        .toast-icon {
            transition: transform 0.2s ease-in-out;
        }
        
        .toast-icon:hover {
            transform: rotate(90deg);
        }
    </style>
    
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://unpkg.com/heroicons@2.0.16/outline/style.css">
    
    <!-- Additional Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 flex flex-col min-h-screen font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-xl backdrop-blur-lg bg-opacity-95 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('products.index') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">HealthHub</span>
                </a>
                


                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all duration-200 group">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @if(count(session('cart', [])) > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-semibold">
                                    {{ count(session('cart', [])) }}
                                </span>
                            @endif
                        </a>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-2 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50">
                                <div class="w-8 h-8 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="font-medium hidden sm:block">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div 
                                x-show="open" 
                                @click.away="open = false" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                            >
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Edit Profil
                                </a>
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Panel Admin
                                    </a>
                                @endif
                                <div class="border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-teal-600 font-medium transition-colors duration-200">Masuk</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold rounded-lg hover:from-teal-700 hover:to-cyan-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden" x-data="{ mobileMenuOpen: false }">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-gray-600 hover:text-teal-600 hover:bg-teal-50 rounded-lg">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Mobile menu -->
                    <div x-show="mobileMenuOpen" 
                         @click.away="mobileMenuOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-4 top-16 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                        
                        <div class="py-2">
                            <a href="{{ route('products.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Produk
                                </div>
                            </a>
                            
                            @auth
                                <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                        </svg>
                                        Dashboard
                                    </div>
                                </a>
                                
                                <a href="{{ route('cart.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
                                            </svg>
                                            Keranjang
                                        </div>
                                        @if(count(session('cart', [])) > 0)
                                            <span class="bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs font-semibold">
                                                {{ count(session('cart', [])) }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profil
                                    </div>
                                </a>
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Panel Admin
                                        </div>
                                    </a>
                                @endif
                                
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                                </svg>
                                                Keluar
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Masuk
                                    </div>
                                </a>
                                
                                <a href="{{ route('register') }}" class="block px-4 py-3 text-gray-700 hover:bg-teal-50 hover:text-teal-600 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Daftar
                                    </div>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
        <!-- Subtle Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-teal-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-cyan-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 py-16 relative z-10">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        {{-- <div class="w-12 h-12 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div> --}}
                        <span class="text-3xl font-bold bg-gradient-to-r from-teal-400 to-cyan-400 bg-clip-text text-transparent">HealthHub</span>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed text-lg">Perlengkapan medis profesional dan perlengkapan untuk penyedia layanan kesehatan. Produk berkualitas dengan layanan terpercaya dan pengiriman cepat ke seluruh Indonesia.</p>
                    
                    <!-- Trust Badges -->
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center space-x-2 bg-gradient-to-r from-teal-500/10 to-cyan-500/10 backdrop-blur-sm rounded-full px-4 py-2 border border-teal-500/20">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm text-gray-300">Produk Terjamin</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gradient-to-r from-cyan-500/10 to-teal-500/10 backdrop-blur-sm rounded-full px-4 py-2 border border-cyan-500/20">
                            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                            <span class="text-sm text-gray-300">Pengiriman Cepat</span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gradient-to-r from-teal-500/10 to-cyan-500/10 backdrop-blur-sm rounded-full px-4 py-2 border border-teal-500/20">
                            <div class="w-2 h-2 bg-purple-400 rounded-full pulse-dot"></div>
                            <span class="text-sm text-gray-300">Layanan 24/7</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <div class="w-1 h-6 bg-gradient-to-b from-teal-400 to-cyan-400 rounded-full mr-3"></div>
                        Tautan Cepat
                    </h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('products.index') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                                Katalog Produk
                            </a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('dashboard') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                    <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    </svg>
                                    Dashboard Saya
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cart.index') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                    <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Keranjang Belanja
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.edit') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                    <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('register') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                    <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Daftar Akun
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}" class="flex items-center text-gray-300 hover:text-teal-400 transition-all duration-300 group">
                                    <svg class="w-4 h-4 mr-3 text-teal-400 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Masuk
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                        <div class="w-1 h-6 bg-gradient-to-b from-cyan-400 to-teal-400 rounded-full mr-3"></div>
                        Hubungi Kami
                    </h3>
                    <div class="space-y-4">
                        <div class="group">
                            <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-gray-800/50 to-gray-700/50 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-teal-500/50 transition-all duration-300">
                                <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Alamat</p>
                                    <p class="text-white font-medium">Gresik, Jawa Timur</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="group">
                            <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-gray-800/50 to-gray-700/50 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-cyan-500/50 transition-all duration-300">
                                <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Email</p>
                                    <a href="mailto:info@healthhub.com" class="text-white font-medium hover:text-teal-400 transition-colors duration-200">admin@healthhub.com</a>
                                </div>
                            </div>
                        </div>
                        
                        {{-- <div class="group">
                            <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-gray-800/50 to-gray-700/50 backdrop-blur-sm rounded-xl border border-gray-700/50 hover:border-teal-500/50 transition-all duration-300">
                                <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Telepon</p>
                                    <a href="tel:+622112345678" class="text-white font-medium hover:text-cyan-400 transition-colors duration-200">+62 21 1234 5678</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gradient-to-r from-transparent via-gray-700 to-transparent pt-8">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-2">
                        <p class="text-gray-400">&copy; {{ date('Y') }} HealthHub.</p>
                        <span class="text-gray-600">•</span>
                        <p class="text-gray-400">Semua hak dilindungi undang-undang.</p>
                    </div>
                    <div class="flex flex-wrap justify-center lg:justify-end gap-8">
                        <a href="#" class="text-gray-400 hover:text-teal-400 transition-all duration-300 relative group">
                            <span class="relative z-10">Kebijakan Privasi</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-teal-400 to-cyan-400 group-hover:w-full transition-all duration-300"></div>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-cyan-400 transition-all duration-300 relative group">
                            <span class="relative z-10">Syarat Layanan</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-cyan-400 to-teal-400 group-hover:w-full transition-all duration-300"></div>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-teal-400 transition-all duration-300 relative group">
                            <span class="relative z-10">Kebijakan Cookie</span>
                            <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-teal-400 to-cyan-400 group-hover:w-full transition-all duration-300"></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Simple Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white/80 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center h-full">
            <div class="flex flex-col items-center space-y-4">
                <div class="loading-spinner"></div>
                <span class="text-teal-600 font-medium">Memuat...</span>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced UX -->
    <script>
        // Simple loading overlay for form submissions
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            const loadingOverlay = document.getElementById('loadingOverlay');

            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    // Only show loading for non-search forms
                    if (!form.classList.contains('search-form')) {
                        loadingOverlay.classList.remove('hidden');
                    }
                });
            });

            // Hide loading overlay on page load
            window.addEventListener('load', function() {
                loadingOverlay.classList.add('hidden');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        // Professional Toast Notification System - Anti-Duplicate with Throttling
        let toastQueue = [];
        let isShowingToast = false;
        let toastCounter = 0;
        let recentToasts = new Map(); // Track recent toasts with timestamps
        let activeToastId = null;
        let lastToastTime = 0;
        const TOAST_THROTTLE_DELAY = 1000; // Minimum 1 second between toasts

        function showToast(message, type = 'info', duration = 4000) {
            const now = Date.now();
            const toastKey = `${message}-${type}`;
            
            console.log(`[TOAST] Attempting to show: "${message}" (${type}) at ${now}`);
            console.log(`[TOAST] Recent toasts:`, Array.from(recentToasts.entries()));
            console.log(`[TOAST] Currently showing:`, isShowingToast, `Active ID:`, activeToastId);
            
            // Global throttling - prevent any toast within throttle delay
            if (now - lastToastTime < TOAST_THROTTLE_DELAY) {
                console.log(`[TOAST] THROTTLED: Too frequent (${now - lastToastTime}ms since last)`);
                return;
            }
            
            // Check if this exact toast was shown recently (within 3 seconds)
            if (recentToasts.has(toastKey)) {
                const lastShown = recentToasts.get(toastKey);
                const timeDiff = now - lastShown;
                if (timeDiff < 3000) {
                    console.log(`[TOAST] DUPLICATE PREVENTED: "${message}" (last shown ${timeDiff}ms ago)`);
                    return;
                }
            }
            
            // Update last toast time
            lastToastTime = now;
            
            // Remove any existing toast immediately to prevent stacking
            const existingToast = document.getElementById('toast-notification');
            if (existingToast) {
                existingToast.remove();
                isShowingToast = false;
                // Clear any pending timeouts
                if (existingToast.autoRemoveTimeout) {
                    clearTimeout(existingToast.autoRemoveTimeout);
                }
            }

            // Clear toast container completely
            const toastContainer = document.querySelector('.toast-container');
            if (toastContainer) {
                toastContainer.innerHTML = '';
            }

            // Add to recent toasts tracker
            recentToasts.set(toastKey, now);
            
            // Clean up old entries from recentToasts (older than 10 seconds)
            setTimeout(() => {
                for (let [key, timestamp] of recentToasts.entries()) {
                    if (now - timestamp > 10000) {
                        recentToasts.delete(key);
                    }
                }
            }, 1000);

            // Set showing state
            isShowingToast = true;
            toastCounter++;
            activeToastId = `toast-${toastCounter}-${now}`;

            // Create toast container if it doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container';
                document.body.appendChild(toastContainer);
            }

            // Create toast with unique ID
            const toast = document.createElement('div');
            toast.id = 'toast-notification';
            toast.dataset.message = message;
            toast.dataset.toastId = activeToastId;
            toast.dataset.timestamp = now;
            toast.className = `toast-item toast-backdrop toast-shadow max-w-sm mb-4 rounded-2xl border-2 overflow-hidden`;
            
            // Set colors and styling based on type
            let bgGradient, borderColor, iconPath, iconColor, textColor, closeColor, accentColor;
            switch(type) {
                case 'success':
                    bgGradient = 'bg-gradient-to-br from-green-50/95 via-emerald-50/95 to-green-100/95';
                    borderColor = 'border-green-200';
                    iconColor = 'text-green-600';
                    textColor = 'text-green-800';
                    closeColor = 'text-green-400 hover:text-green-600';
                    accentColor = 'bg-gradient-to-r from-green-400 to-emerald-500';
                    iconPath = 'M5 13l4 4L19 7';
                    break;
                case 'error':
                    bgGradient = 'bg-gradient-to-br from-red-50/95 via-pink-50/95 to-red-100/95';
                    borderColor = 'border-red-200';
                    iconColor = 'text-red-600';
                    textColor = 'text-red-800';
                    closeColor = 'text-red-400 hover:text-red-600';
                    accentColor = 'bg-gradient-to-r from-red-400 to-pink-500';
                    iconPath = 'M6 18L18 6M6 6l12 12';
                    break;
                case 'info':
                    bgGradient = 'bg-gradient-to-br from-teal-50/95 via-cyan-50/95 to-teal-100/95';
                    borderColor = 'border-teal-200';
                    iconColor = 'text-teal-600';
                    textColor = 'text-teal-800';
                    closeColor = 'text-teal-400 hover:text-teal-600';
                    accentColor = 'bg-gradient-to-r from-teal-400 to-cyan-500';
                    iconPath = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                    break;
            }
            
            toast.className += ` ${bgGradient} ${borderColor}`;
            
            toast.innerHTML = `
                <!-- Accent bar -->
                <div class="h-1 ${accentColor}"></div>
                
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 ${accentColor} rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="${iconPath}"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-bold ${textColor} leading-5 mb-1">${message}</p>
                            <p class="text-xs ${iconColor} opacity-80">
                                ${type === 'success' ? '✨ Produk berhasil ditambahkan ke keranjang!' : 
                                  type === 'error' ? '⚠️ Terjadi kesalahan, silakan coba lagi.' : 
                                  '💡 Informasi penting untuk Anda.'}
                            </p>
                        </div>
                        <div class="ml-3 flex-shrink-0">
                            <button type="button" onclick="closeToast()" class="inline-flex ${closeColor} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-${type === 'success' ? 'green' : type === 'error' ? 'red' : 'teal'}-300 rounded-lg p-1.5 hover:bg-white/30 transition-all duration-200 toast-icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Progress bar -->
                <div class="h-1 bg-white/20">
                    <div class="h-full ${accentColor} transition-all duration-${duration} ease-linear" style="width: 100%; animation: shrinkWidth ${duration}ms linear;"></div>
                </div>
            `;
            
            toastContainer.appendChild(toast);
            
            // Add CSS animation for progress bar
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shrinkWidth {
                    from { width: 100%; }
                    to { width: 0%; }
                }
            `;
            document.head.appendChild(style);
            
            // Auto remove
            const autoRemove = setTimeout(() => {
                closeToast();
            }, duration);

            // Store timeout for manual close
            toast.autoRemoveTimeout = autoRemove;
        }

        function closeToast(forceClose = false) {
            const toast = document.getElementById('toast-notification');
            if (toast) {
                // Prevent multiple close attempts
                if (toast.dataset.closing === 'true' && !forceClose) {
                    return;
                }
                
                toast.dataset.closing = 'true';
                
                // Clear auto remove timeout
                if (toast.autoRemoveTimeout) {
                    clearTimeout(toast.autoRemoveTimeout);
                }
                
                // Add closing animation
                toast.classList.add('closing');
                
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                    isShowingToast = false;
                    activeToastId = null;
                    
                    // Show next toast in queue with delay
                    if (toastQueue.length > 0) {
                        const next = toastQueue.shift();
                        setTimeout(() => showToast(next.message, next.type, next.duration), 500);
                    }
                }, 300);
            } else {
                // Reset state if no toast found
                isShowingToast = false;
                activeToastId = null;
            }
        }

        // Global function to clear all toasts
        function clearAllToasts() {
            const toastContainer = document.querySelector('.toast-container');
            if (toastContainer) {
                toastContainer.innerHTML = '';
            }
            const toast = document.getElementById('toast-notification');
            if (toast) {
                toast.remove();
            }
            toastQueue = [];
            isShowingToast = false;
            activeToastId = null;
            recentToasts.clear();
        }

        // Show toast for authentication redirects
        @if(request()->has('redirect'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Silakan masuk untuk melanjutkan berbelanja', 'info');
            });
        @endif

        // Enhanced session message handling - Single execution only
        let sessionProcessed = false;
        
        function processSessionMessages() {
            // Prevent multiple executions
            if (sessionProcessed) {
                console.log('Session messages already processed, skipping...');
                return;
            }
            
            sessionProcessed = true;
            let sessionMessages = [];
            
            @if(session('success'))
                sessionMessages.push({ 
                    message: '{{ addslashes(session('success')) }}', 
                    type: 'success', 
                    priority: 1,
                    duration: 4500
                });
            @endif
            
            @if(session('error'))
                sessionMessages.push({ 
                    message: '{{ addslashes(session('error')) }}', 
                    type: 'error', 
                    priority: 3,
                    duration: 6000
                });
            @endif

            @if(session('info'))
                sessionMessages.push({ 
                    message: '{{ addslashes(session('info')) }}', 
                    type: 'info', 
                    priority: 2,
                    duration: 4000
                });
            @endif

            // Sort by priority (higher number = higher priority)
            sessionMessages.sort((a, b) => b.priority - a.priority);
            
            // Show only the highest priority message to avoid duplicates
            if (sessionMessages.length > 0) {
                const primaryMessage = sessionMessages[0];
                console.log('Processing session message:', primaryMessage.message, primaryMessage.type);
                
                // Delay to ensure DOM is fully ready and prevent race conditions
                setTimeout(() => {
                    showToast(primaryMessage.message, primaryMessage.type, primaryMessage.duration);
                }, 800);
            }
        }

        // Process session messages only once when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', processSessionMessages);
        } else {
            // If DOM is already loaded, process immediately
            processSessionMessages();
        }

        // Global event listener to prevent multiple toast triggers
        let eventListenerAdded = false;
        
        function addGlobalToastProtection() {
            if (eventListenerAdded) return;
            eventListenerAdded = true;
            
            // Intercept any potential duplicate toast calls
            const originalConsoleLog = console.log;
            console.log = function(...args) {
                if (args[0] && args[0].includes && args[0].includes('toast')) {
                    originalConsoleLog.apply(console, ['[TOAST DEBUG]', ...args]);
                } else {
                    originalConsoleLog.apply(console, args);
                }
            };
            
            // Clear any existing toasts on page navigation/reload
            window.addEventListener('beforeunload', clearAllToasts);
            
            // Prevent multiple toasts on rapid clicks
            document.addEventListener('click', function(e) {
                if (e.target.closest('form') || e.target.closest('[onclick]')) {
                    setTimeout(clearAllToasts, 100);
                }
            });
        }
        
        addGlobalToastProtection();
    </script>
</body>
</html>
