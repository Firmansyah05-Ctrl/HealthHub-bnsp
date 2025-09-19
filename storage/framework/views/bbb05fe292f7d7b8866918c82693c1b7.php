

<?php $__env->startSection('title', 'Kelola Produk - Admin HealthHub'); ?>
<?php $__env->startSection('description', 'Kelola semua produk alat kesehatan di HealthHub dengan interface modern.'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .filter-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Enhanced smooth transitions for description expansion */
        .product-description {
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                       -webkit-line-clamp 0.3s ease-in-out,
                       opacity 0.2s ease-in-out;
            overflow: hidden;
        }

        /* Icon rotation animation with bounce effect */
        .toggle-icon {
            transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Fade gradient animation */
        .fade-gradient {
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
        }

        /* Button hover animations */
        .product-card-hover {
            transition: all 0.2s ease-in-out;
        }

        .product-card-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Smooth gradient transitions */
        .gradient-button {
            background-size: 200% 200%;
            transition: background-position 0.3s ease-in-out, transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .gradient-button:hover {
            background-position: right center;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1
                            class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">
                            Kelola Produk
                        </h1>
                        <p class="mt-2 text-gray-600">Kelola semua produk dan alat kesehatan dengan mudah</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('admin.products.create')); ?>"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>

            
            <?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Advanced Filters -->
            <div class="filter-card rounded-2xl shadow-xl p-6 mb-8 border border-white">
                <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter & Pencarian
                        </h3>
                        <?php if(request()->hasAny(['search', 'category', 'min_price', 'max_price'])): ?>
                            <a href="<?php echo e(route('admin.products.index')); ?>"
                                class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reset Filter
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                            <div class="relative">
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                    placeholder="Nama produk, deskripsi, atau kategori..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <option value="">Semua Kategori</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"
                                        <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                            <div class="flex space-x-2">
                                <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" placeholder="Min"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" placeholder="Max"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Products List -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Daftar Produk
                        </h2>
                        <span class="text-sm text-gray-500">
                            Menampilkan <?php echo e($products->firstItem() ?? 0); ?> - <?php echo e($products->lastItem() ?? 0); ?> dari
                            <?php echo e($products->total()); ?> produk
                        </span>
                    </div>
                </div>

                <?php if($products->count() > 0): ?>
                    <div class="overflow-x-auto shadow-inner rounded-2xl">
                        <table class="min-w-full table-auto bg-white">
                            <thead class="bg-gradient-to-r from-purple-100 via-blue-100 to-teal-100">
                                <tr>
                                    <th class="px-6 py-5 text-left text-sm font-bold uppercase tracking-wider w-20 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                                        #</th>
                                    <th class="px-6 py-5 text-left text-sm font-bold uppercase tracking-wider bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                                        Produk</th>
                                    <th class="px-6 py-5 text-left text-sm font-bold uppercase tracking-wider w-40 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                                        Kategori</th>
                                    <th class="px-6 py-5 text-left text-sm font-bold uppercase tracking-wider w-32 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                                        Harga</th>
                                    <th class="px-6 py-5 text-center text-sm font-bold uppercase tracking-wider w-32 bg-gradient-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 border-b border-gray-100">
                                        <td class="px-6 py-6 whitespace-nowrap text-sm font-bold text-gray-900 w-16 align-top">
                                            <div class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-full text-xs font-bold mt-1">
                                                <?php echo e($products->firstItem() + $index); ?>

                                            </div>
                                        </td>
                                        <td class="px-6 py-6 align-top">
                                            <div class="flex items-start space-x-4">
                                                <!-- Product Image -->
                                                <div class="flex-shrink-0">
                                                    <?php if($product->image_url): ?>
                                                        <img src="<?php echo e(Storage::url($product->image_url)); ?>"
                                                            alt="<?php echo e($product->name); ?>" 
                                                            class="w-20 h-20 object-cover rounded-xl border-2 border-gray-200 shadow-sm"
                                                            style="background-color: white; display: block;">
                                                    <?php else: ?>
                                                        <div class="w-20 h-20 bg-gray-300 rounded-xl flex items-center justify-center border-2 border-gray-200">
                                                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" />
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Product Details -->
                                                <div class="flex-grow min-w-0 space-y-4">
                                                    <!-- Product Name -->
                                                    <div class="space-y-2">
                                                        <h4 class="text-lg font-bold text-gray-900 leading-tight hover:text-purple-600 transition-colors duration-200">
                                                            <?php echo e($product->name); ?>

                                                        </h4>
                                                        
                                                    </div>
                                                    
                                                    <!-- Product Description -->
                                                    <?php if($product->description): ?>
                                                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                            <p class="product-description text-xs text-gray-700 leading-relaxed line-clamp-3" 
                                                               id="admin-desc-<?php echo e($product->id); ?>"
                                                               style="max-width: 400px; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                                                                <?php echo e($product->description); ?>

                                                            </p>
                                                            
                                                            <?php if(strlen($product->description) > 100): ?>
                                                                <div class="mt-2 flex justify-end">
                                                                    <button class="toggle-btn inline-flex items-center text-xs font-semibold text-white bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 px-3 py-1.5 rounded-full transition-all duration-200 group shadow-sm hover:shadow-md transform hover:scale-105"
                                                                            id="admin-toggle-<?php echo e($product->id); ?>"
                                                                            data-product-id="<?php echo e($product->id); ?>"
                                                                            type="button">
                                                                        <svg class="toggle-icon w-3 h-3 mr-1.5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                                        </svg>
                                                                        <span>Baca Selengkapnya</span>
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                            <p class="text-xs text-gray-500 italic">Tidak ada deskripsi produk</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 w-40 align-top">
                                            <?php if($product->category): ?>
                                                <div class="space-y-3">
                                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-xs font-semibold bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-lg">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                        </svg>
                                                        <?php echo e($product->category->name); ?>

                                                    </span>
                                                    <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                        <?php if($product->stock > 10): ?>
                                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-green-700 font-medium text-xs">Stok Tersedia</span>
                                                        <?php elseif($product->stock > 0): ?>
                                                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-yellow-700 font-medium text-xs">Stok Terbatas</span>
                                                        <?php else: ?>
                                                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-red-700 font-medium text-xs">Stok Habis</span>
                                                        <?php endif; ?>
                                                        <span class="ml-2 text-gray-600 font-bold text-xs">(<?php echo e($product->stock); ?>)</span>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="space-y-3">
                                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-xs font-medium bg-gray-200 text-gray-700 border">
                                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Tanpa Kategori
                                                    </span>
                                                    <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                        <?php if($product->stock > 10): ?>
                                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-green-700 font-medium text-xs">Stok Tersedia</span>
                                                        <?php elseif($product->stock > 0): ?>
                                                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-yellow-700 font-medium text-xs">Stok Terbatas</span>
                                                        <?php else: ?>
                                                            <div class="w-3 h-3 bg-red-500 rounded-full mr-2 animate-pulse"></div>
                                                            <span class="text-red-700 font-medium text-xs">Stok Habis</span>
                                                        <?php endif; ?>
                                                        <span class="ml-2 text-gray-600 font-bold text-xs">(<?php echo e($product->stock); ?>)</span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-6 w-32 align-top">
                                            <div class="mt-1">
                                                <div class="text-xl font-bold text-gray-900 mb-1">
                                                    Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                                </div>
                                                <div class="text-sm text-gray-500 font-medium">
                                                    Harga Satuan
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-center w-32 align-top">
                                            <div class="flex flex-col space-y-3">
                                                <a href="<?php echo e(route('admin.products.edit', $product)); ?>"
                                                    class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-sm font-medium rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                                                    title="Edit Produk">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" class="inline" 
                                                      onsubmit="return confirm('Yakin ingin menghapus produk: <?php echo e(addslashes($product->name)); ?>?\n\nTindakan ini tidak dapat dibatalkan!')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-medium rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                                                        title="Hapus Produk">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <?php echo e($products->appends(request()->query())->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk pertama Anda.</p>
                        <div class="mt-6">
                            <a href="<?php echo e(route('admin.products.create')); ?>"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Produk Pertama
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Toggle Description -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing toggle buttons');
            
            // Add event listeners to all toggle buttons
            const toggleButtons = document.querySelectorAll('.toggle-btn');
            console.log('Found toggle buttons:', toggleButtons.length);
            
            toggleButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    console.log('Button clicked for product:', productId);
                    
                    const desc = document.getElementById('admin-desc-' + productId);
                    const toggleText = this.querySelector('span');
                    const toggleIcon = this.querySelector('.toggle-icon');
                    
                    if (!desc || !toggleText || !toggleIcon) {
                        console.error('Elements not found for product:', productId);
                        return;
                    }
                    
                    // Simple toggle logic
                    if (desc.classList.contains('line-clamp-3')) {
                        // Expand
                        desc.classList.remove('line-clamp-3');
                        desc.style.display = 'block';
                        desc.style.webkitLineClamp = 'unset';
                        desc.style.webkitBoxOrient = 'unset';
                        toggleText.textContent = 'Sembunyikan';
                        toggleIcon.style.transform = 'rotate(180deg)';
                        console.log('Expanded description for product:', productId);
                    } else {
                        // Collapse
                        desc.classList.add('line-clamp-3');
                        desc.style.display = '-webkit-box';
                        desc.style.webkitLineClamp = '3';
                        desc.style.webkitBoxOrient = 'vertical';
                        toggleText.textContent = 'Baca Selengkapnya';
                        toggleIcon.style.transform = 'rotate(0deg)';
                        console.log('Collapsed description for product:', productId);
                    }
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DOKUMEN\BNSP\example-app\resources\views/admin/products/index.blade.php ENDPATH**/ ?>