<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4 col-lg-6">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit User</h5>
    <form method="POST" action="<?php echo e(route('users.update', $user)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <?php echo $__env->make('users._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/users/edit.blade.php ENDPATH**/ ?>