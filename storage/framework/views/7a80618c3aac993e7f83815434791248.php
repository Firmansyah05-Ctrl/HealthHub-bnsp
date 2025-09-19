

<?php $__env->startSection('title', 'Admin Dashboard - HealthHub'); ?>
<?php $__env->startSection('description', 'Panel admin untuk mengelola produk, pesanan, dan pengguna di HealthHub.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom scrollbar for admin cards */
    .admin-card-scroll {
        scrollbar-width: thin;
        scrollbar-color: #14b8a6 #f1f5f9;
    }
    
    .admin-card-scroll::-webkit-scrollbar {
        width: 6px;
    }
    
    .admin-card-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .admin-card-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #14b8a6, #06b6d4);
        border-radius: 3px;
    }
    
    .admin-card-scroll::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #0f766e, #0891b2);
    }
    
    /* Smooth transitions for admin cards */
    .admin-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .admin-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(20, 184, 166, 0.1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl p-8 mb-8 text-white">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Selamat datang kembali, <?php echo e(Auth::user()->name); ?>!</h1>
            <p class="text-teal-100 text-lg">Kelola sistem HealthHub dan pantau performa platform medis</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($statistics['total_orders']); ?></p>
                    <p class="text-gray-600">Total Pesanan</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">Rp <?php echo e(number_format($statistics['total_revenue'], 0, ',', '.')); ?></p>
                    <p class="text-gray-600">Total Revenue</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($statistics['total_users']); ?></p>
                    <p class="text-gray-600">Active Users</p>
                </div>
            </div>
        </div>
    </div>



    <!-- Detailed Management Cards -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Panel Manajemen</h2>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                <!-- Kelola Produk -->
                <a href="<?php echo e(route('admin.products.index')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-teal-50 to-cyan-50 rounded-3xl shadow-xl hover:shadow-2xl border border-teal-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-teal-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-teal-100 to-teal-200 rounded-2xl flex items-center justify-center group-hover:from-teal-500 group-hover:to-cyan-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-teal-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent"><?php echo e($statistics['total_products']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Total Produk</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-teal-700 transition-colors duration-300">Kelola Produk</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Tambah, edit, dan hapus produk medis dengan mudah</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-teal-600 group-hover:text-teal-700 font-semibold">
                                <span class="text-sm">Kelola Sekarang</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

                <!-- Kelola Stok -->
                <a href="<?php echo e(route('admin.products.stock')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-blue-50 to-indigo-50 rounded-3xl shadow-xl hover:shadow-2xl border border-blue-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-blue-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center group-hover:from-blue-500 group-hover:to-indigo-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"><?php echo e($statistics['total_stock']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Total Stok</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-700 transition-colors duration-300">Kelola Stok</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Monitor dan update stok produk secara real-time</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-blue-600 group-hover:text-blue-700 font-semibold">
                                <span class="text-sm">Monitor Stok</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

                <!-- Kelola Kategori -->
                <a href="<?php echo e(route('admin.categories.index')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-emerald-50 to-green-50 rounded-3xl shadow-xl hover:shadow-2xl border border-emerald-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-400 to-green-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-emerald-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-emerald-200 rounded-2xl flex items-center justify-center group-hover:from-emerald-500 group-hover:to-green-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-emerald-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent"><?php echo e($statistics['total_categories']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Kategori</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-700 transition-colors duration-300">Kelola Kategori</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Atur dan kelola kategori produk medis</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-emerald-600 group-hover:text-emerald-700 font-semibold">
                                <span class="text-sm">Atur Kategori</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

                <!-- Kelola User -->
                <a href="<?php echo e(route('admin.users.index')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-purple-50 to-pink-50 rounded-3xl shadow-xl hover:shadow-2xl border border-purple-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-purple-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center group-hover:from-purple-500 group-hover:to-pink-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-purple-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent"><?php echo e($statistics['total_users']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Total User</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-700 transition-colors duration-300">Kelola User</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Manajemen akun pengguna dan hak akses</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-purple-600 group-hover:text-purple-700 font-semibold">
                                <span class="text-sm">Kelola User</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-purple-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

                <!-- Kelola Pesanan -->
                <a href="<?php echo e(route('admin.orders.index')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-indigo-50 to-blue-50 rounded-3xl shadow-xl hover:shadow-2xl border border-indigo-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-indigo-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center group-hover:from-indigo-500 group-hover:to-blue-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent"><?php echo e($statistics['total_orders']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Total Order</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-indigo-700 transition-colors duration-300">Kelola Pesanan</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Lihat, update, dan kelola pesanan pelanggan</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-indigo-600 group-hover:text-indigo-700 font-semibold">
                                <span class="text-sm">Kelola Pesanan</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

                <!-- Kelola Feedback -->
                <a href="<?php echo e(route('admin.feedbacks.index')); ?>" 
                   class="admin-card group relative bg-gradient-to-br from-white via-amber-50 to-orange-50 rounded-3xl shadow-xl hover:shadow-2xl border border-amber-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-amber-300 to-transparent rounded-tr-full opacity-5"></div>
                    <div class="relative p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl flex items-center justify-center group-hover:from-amber-500 group-hover:to-orange-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                <svg class="w-8 h-8 text-amber-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent"><?php echo e($statistics['total_feedback']); ?></div>
                                <div class="text-sm text-gray-500 font-medium">Feedback</div>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-amber-700 transition-colors duration-300">Kelola Feedback</h3>
                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">Pantau dan analisis ulasan pengguna</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-amber-600 group-hover:text-amber-700 font-semibold">
                                <span class="text-sm">Lihat Feedback</span>
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </a>

            </div>
            
            <!-- Card Permohonan Toko - Centered on its own row -->
            <div class="flex justify-center mt-8">
                <div class="w-full max-w-sm">
                    <a href="<?php echo e(route('admin.shop_requests.index')); ?>" 
                       class="admin-card group relative bg-gradient-to-br from-white via-rose-50 to-pink-50 rounded-3xl shadow-xl hover:shadow-2xl border border-rose-100 overflow-hidden transform hover:-translate-y-4 transition-all duration-500 block">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-rose-400 to-pink-500 rounded-bl-full opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-rose-300 to-transparent rounded-tr-full opacity-5"></div>
                        <div class="relative p-8">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 bg-gradient-to-br from-rose-100 to-rose-200 rounded-2xl flex items-center justify-center group-hover:from-rose-500 group-hover:to-pink-600 group-hover:scale-110 transition-all duration-300 shadow-lg">
                                    <svg class="w-8 h-8 text-rose-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent"><?php echo e($statistics['total_shop_requests']); ?></div>
                                    <div class="text-sm text-gray-500 font-medium">Permintaan</div>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-rose-700 transition-colors duration-300">Permohonan Toko</h3>
                            <p class="text-gray-600 text-sm mb-6 leading-relaxed">Kelola dan review permohonan toko baru</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-rose-600 group-hover:text-rose-700 font-semibold">
                                    <span class="text-sm">Lihat Permintaan</span>
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                                <div class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Recent Orders Overview -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-teal-600 hover:text-teal-700 font-medium text-sm">
                    Lihat Semua
                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <?php if($statistics['recent_orders']->count() > 0): ?>
            <div class="divide-y divide-gray-200">
                <?php $__currentLoopData = $statistics['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center">
                                    <span class="text-teal-600 font-semibold text-sm">#<?php echo e($order->id); ?></span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900"><?php echo e($order->user->name ?? 'User tidak ditemukan'); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($order->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($order->orderItems->sum('quantity')); ?> item</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-600">Pesanan akan muncul di sini setelah ada transaksi</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DOKUMEN\BNSP\example-app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>