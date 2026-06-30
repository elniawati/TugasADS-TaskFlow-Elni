<?php $__env->startSection('title', 'Halaman Tidak Ditemukan'); ?>
<?php $__env->startSection('content'); ?>
<div class="text-center">
    <i class="bi bi-search text-secondary" style="font-size:3rem;"></i>
    <h4 class="mt-3">404 - Halaman Tidak Ditemukan</h4>
    <p class="text-secondary">Halaman yang Anda cari tidak tersedia.</p>
    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/errors/404.blade.php ENDPATH**/ ?>