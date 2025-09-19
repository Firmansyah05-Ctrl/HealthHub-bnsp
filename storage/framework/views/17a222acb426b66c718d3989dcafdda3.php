

<?php $__env->startSection('title', 'Kelola Feedback - Admin HealthHub'); ?>
<?php $__env->startSection('description', 'Kelola dan analisis feedback pelanggan di HealthHub.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .rating-stars {
        color: #fbbf24;
    }
    
    .feedback-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .feedback-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .rating-5 {
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
    }
    
    .rating-4 {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
    }
    
    .rating-3 {
        background: linear-gradient(135deg, #ca8a04 0%, #eab308 100%);
    }
    
    .rating-2 {
        background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
    }
    
    .rating-1 {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-2xl p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">Kelola Feedback</h1>
                </div>
                <p class="text-amber-100 text-lg">Pantau dan analisis ulasan pelanggan untuk meningkatkan layanan</p>
            </div>
            <div class="hidden md:block">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold"><?php echo e($statistics['total_feedbacks']); ?></div>
                        <div class="text-amber-200 text-sm">Total Feedback</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold"><?php echo e($statistics['average_rating']); ?></div>
                        <div class="text-amber-200 text-sm">Rata-rata Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-2xl p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold text-green-700"><?php echo e($statistics['five_star']); ?></div>
                    <div class="text-green-600 text-sm">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-teal-50 to-cyan-100 rounded-2xl p-4 border border-teal-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold text-teal-700"><?php echo e($statistics['four_star']); ?></div>
                    <div class="text-teal-600 text-sm">⭐⭐⭐⭐</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-2xl p-4 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold text-yellow-700"><?php echo e($statistics['three_star']); ?></div>
                    <div class="text-yellow-600 text-sm">⭐⭐⭐</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-red-100 rounded-2xl p-4 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold text-orange-700"><?php echo e($statistics['two_star']); ?></div>
                    <div class="text-orange-600 text-sm">⭐⭐</div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-rose-100 rounded-2xl p-4 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-xl font-bold text-red-700"><?php echo e($statistics['one_star']); ?></div>
                    <div class="text-red-600 text-sm">⭐</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <form method="GET" action="<?php echo e(route('admin.feedbacks.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Cari berdasarkan komentar atau nama pengguna..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            </div>

            <!-- Rating Filter -->
            <div>
                <select name="rating" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <option value="all">Semua Rating</option>
                    <option value="5" <?php echo e(request('rating') == '5' ? 'selected' : ''); ?>>⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4" <?php echo e(request('rating') == '4' ? 'selected' : ''); ?>>⭐⭐⭐⭐ (4)</option>
                    <option value="3" <?php echo e(request('rating') == '3' ? 'selected' : ''); ?>>⭐⭐⭐ (3)</option>
                    <option value="2" <?php echo e(request('rating') == '2' ? 'selected' : ''); ?>>⭐⭐ (2)</option>
                    <option value="1" <?php echo e(request('rating') == '1' ? 'selected' : ''); ?>>⭐ (1)</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full px-4 py-3 bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition-colors duration-200 font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Feedbacks List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-900">Daftar Feedback Pelanggan</h2>
        </div>
        
        <?php if($feedbacks->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($feedbacks->firstItem() + $index); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-semibold mr-3">
                                            <?php echo e(substr($fb->user->name ?? 'U', 0, 2)); ?>

                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($fb->user->name ?? 'User tidak ditemukan'); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($fb->user->email ?? '-'); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($fb->order && $fb->order->orderItems->count()): ?>
                                        <div class="space-y-1">
                                            <?php $__currentLoopData = $fb->order->orderItems->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($item->product->name ?? 'Produk tidak ditemukan'); ?> 
                                                    <span class="text-amber-600 font-medium">× <?php echo e($item->quantity); ?></span>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($fb->order->orderItems->count() > 2): ?>
                                                <div class="text-sm text-gray-500">+<?php echo e($fb->order->orderItems->count() - 2); ?> produk lainnya</div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <?php
                                            $ratingClass = match($fb->rating) {
                                                5 => 'rating-5',
                                                4 => 'rating-4',
                                                3 => 'rating-3',
                                                2 => 'rating-2',
                                                1 => 'rating-1',
                                                default => 'bg-gray-500'
                                            };
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white <?php echo e($ratingClass); ?>">
                                            <?php echo e($fb->rating); ?>/5
                                        </span>
                                        <div class="text-yellow-400 text-sm">
                                            <?php echo str_repeat('⭐', $fb->rating); ?>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <p class="text-sm text-gray-900 truncate" title="<?php echo e($fb->comment); ?>">
                                            <?php echo e(Str::limit($fb->comment, 50)); ?>

                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($fb->created_at->format('d M Y')); ?>

                                    <div class="text-xs"><?php echo e($fb->created_at->format('H:i')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <!-- Delete Button Only -->
                                    <form action="<?php echo e(route('admin.feedbacks.destroy', $fb)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus feedback dari <?php echo e($fb->user->name ?? 'user ini'); ?>?')"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition-all duration-300 text-sm font-medium transform hover:scale-105 hover:shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($feedbacks->withQueryString()->links('custom-pagination')); ?>

            </div>

        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\DOKUMEN\BNSP\example-app\resources\views/admin/feedbacks/index.blade.php ENDPATH**/ ?>