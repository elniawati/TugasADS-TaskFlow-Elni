<?php $__env->startSection('title', 'Prioritas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-flag me-1"></i> Prioritas</h5>
        <a href="<?php echo e(route('priorities.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Prioritas</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Nama</th><th>Level</th><th>Warna</th><th>Jumlah Task</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-medium"><?php echo e($priority->name); ?></td>
                        <td><?php echo e($priority->level); ?></td>
                        <td><span class="badge" style="background-color: <?php echo e($priority->color); ?>;">&nbsp;&nbsp;&nbsp;</span></td>
                        <td><?php echo e($priority->tasks_count); ?></td>
                        <td class="text-end">
                            <a href="<?php echo e(route('priorities.edit', $priority)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('priorities.destroy', $priority)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data prioritas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($priorities->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/priorities/index.blade.php ENDPATH**/ ?>