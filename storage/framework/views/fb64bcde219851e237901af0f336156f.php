

<?php $__env->startSection('title', 'Perlengkapan Medis - Produk Kesehatan Profesional'); ?>
<?php $__env->startSection('description', 'Jelajahi koleksi leng                        <!-- Add to Cart Button -->an medis dan peralatan kesehatan profesional. Produk berkualitas untuk penyedia layanan kesehatan.'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col lg:flex-row gap-8">
    <!-- Sidebar for categories -->
    <div class="w-full lg:w-1/4">
        <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
            <h2 class="text-xl font-bold mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Kategori
            </h2>
            <ul class="space-y-1">
                <li>
                    <a href="<?php echo e(route('products.index')); ?>" 
                       class="flex items-center py-3 px-4 rounded-xl transition-all duration-200 <?php echo e(!$selectedCategory ? 'bg-teal-50 text-teal-600 border-l-4 border-teal-600' : 'hover:bg-gray-50 text-gray-700'); ?>">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Semua Produk
                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full"><?php echo e($totalProducts); ?></span>
                    </a>
                </li>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route('products.index', ['category' => $category->slug])); ?>" 
                       class="flex items-center py-3 px-4 rounded-xl transition-all duration-200 <?php echo e($selectedCategory == $category->slug ? 'bg-teal-50 text-teal-600 border-l-4 border-teal-600' : 'hover:bg-gray-50 text-gray-700'); ?>">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <?php echo e($category->name); ?>

                        <span class="ml-auto bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-1 rounded-full"><?php echo e($category->products_count); ?></span>
                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

    <!-- Product grid -->
    <div class="w-full lg:w-3/4">
        <!-- Filter and Sort Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    <?php if($selectedCategory): ?>
                        <?php echo e($categories->where('slug', $selectedCategory)->first()->name ?? 'Produk'); ?>

                    <?php else: ?>
                        Semua Produk
                    <?php endif; ?>
                </h2>
                <p class="text-gray-600"><?php echo e($products->total()); ?> produk tersedia</p>
            </div>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                <form method="GET" action="<?php echo e(route('products.index')); ?>" class="flex items-center search-form" id="sortForm">
                    <?php if($selectedCategory): ?>
                        <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                    <?php endif; ?>
                    <div class="flex items-center space-x-3 bg-white rounded-xl shadow-sm border border-gray-200 px-4 py-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                        <select name="sort" onchange="this.form.submit()" class="text-sm font-medium text-gray-700 bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer">
                            <option value="newest" <?php echo e(request('sort') == 'newest' || !request('sort') ? 'selected' : ''); ?>>Terbaru</option>
                            <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Harga: Rendah ke Tinggi</option>
                            <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Harga: Tinggi ke Rendah</option>
                            <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Nama A-Z</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <?php if($products->count() > 0): ?>
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden group border border-gray-100 hover:border-teal-200 hover:scale-[1.02] transform">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                        <img src="<?php echo e(asset('storage/' . $product->image_url)); ?>" 
                             alt="<?php echo e($product->name); ?>" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        
                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4">
                            <div class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg backdrop-blur-sm">
                                <?php echo e($product->category->name); ?>

                            </div>
                        </div>
                        
                        <!-- Stock Badge -->
                        <div class="absolute top-4 right-4">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full shadow-lg backdrop-blur-sm border border-white/20">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-xs font-semibold">Tersedia</span>
                                </div>
                            </div>
                        </div>

                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-teal-900/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>

                    <!-- Product Details -->
                    <div class="p-7 space-y-5">
                        <!-- Product Title -->
                        <div class="space-y-2">
                            <h3 class="font-bold text-xl text-gray-900 group-hover:text-teal-600 transition-colors duration-300 line-clamp-2 leading-tight">
                                <?php echo e($product->name); ?>

                            </h3>
                            
                            <!-- Product Description with "Read More" functionality -->
                            <div class="space-y-2">
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3" id="desc-<?php echo e($product->id); ?>">
                                    <?php echo e($product->description); ?>

                                </p>
                                <button onclick="toggleDescription(<?php echo e($product->id); ?>)" 
                                        class="text-teal-600 hover:text-teal-700 text-xs font-medium transition-colors duration-200"
                                        id="toggle-<?php echo e($product->id); ?>">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                        
                        <!-- Price Section -->
                        <div class="space-y-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <span class="text-3xl font-bold bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                        Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                    </span>
                                    <div class="flex items-center text-green-600 text-xs font-medium">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                        Stok Tersedia (<?php echo e($product->stock); ?> unit)
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Medical Certification -->
                            <div class="flex items-center justify-center py-2 bg-gradient-to-r from-teal-50 to-cyan-50 rounded-xl border border-teal-100">
                                <svg class="w-4 h-4 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-teal-700 text-xs font-semibold">Sertifikasi Medis Terjamin</span>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <?php if(auth()->guard()->guest()): ?>
                            <!-- Login Required Button -->
                            <a href="<?php echo e(route('login', ['redirect' => url()->current()])); ?>" 
                               class="group w-full bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-3 relative overflow-hidden mt-4">
                                <!-- Shine Effect -->
                                <div class="absolute inset-0 -top-1 -bottom-1 bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                
                                <!-- Background Ripple -->
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                
                                <!-- Login Icon -->
                                <svg class="w-5 h-5 group-hover:scale-110 transition-all duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                
                                <span class="relative z-10 font-semibold text-sm tracking-wide">Masuk untuk Berbelanja</span>
                                
                                <!-- Arrow Icon -->
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        <?php else: ?>
                            <!-- Add to Cart Form -->
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="w-full pt-4">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="group w-full bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-3 relative overflow-hidden">
                                    <!-- Shine Effect -->
                                    <div class="absolute inset-0 -top-1 -bottom-1 bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 transform -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                    
                                    <!-- Background Ripple -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-teal-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Cart Icon -->
                                    <svg class="w-5 h-5 group-hover:scale-110 group-hover:rotate-12 transition-all duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    
                                    <span class="relative z-10 font-semibold text-sm tracking-wide">Tambah ke Keranjang</span>
                                    
                                    <!-- Plus Icon -->
                                    <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- JavaScript for Read More functionality -->
            <script>
                function toggleDescription(productId) {
                    const descElement = document.getElementById('desc-' + productId);
                    const toggleButton = document.getElementById('toggle-' + productId);
                    
                    if (descElement.classList.contains('line-clamp-3')) {
                        descElement.classList.remove('line-clamp-3');
                        toggleButton.textContent = 'Baca Lebih Sedikit';
                    } else {
                        descElement.classList.add('line-clamp-3');
                        toggleButton.textContent = 'Baca Selengkapnya';
                    }
                }
            </script>

            <!-- Pagination -->
            <div class="flex justify-center mt-16">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 backdrop-blur-sm bg-white/95">
                    <?php echo e($products->withQueryString()->links('custom-pagination')); ?>

                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="max-w-lg mx-auto">
                    <div class="w-32 h-32 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">Maaf, kami tidak dapat menemukan produk medis dalam kategori yang Anda pilih. Silakan coba kategori lain atau kembali untuk melihat semua produk tersedia.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-bold rounded-2xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Lihat Semua Produk
                        </a>
                        <button onclick="window.history.back()" class="inline-flex items-center px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl border-2 border-gray-200 hover:border-teal-300 hover:text-teal-600 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                            </svg>
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DOKUMEN\BNSP\example-app\resources\views/products/index.blade.php ENDPATH**/ ?>