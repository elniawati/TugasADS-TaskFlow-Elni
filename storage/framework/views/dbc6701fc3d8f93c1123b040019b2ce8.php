<?php $__env->startSection('title', 'Tambah Task'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <h5 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah Task</h5>
    <form method="POST" action="<?php echo e(route('tasks.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo $__env->make('tasks._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/tasks/create.blade.php ENDPATH**/ ?>