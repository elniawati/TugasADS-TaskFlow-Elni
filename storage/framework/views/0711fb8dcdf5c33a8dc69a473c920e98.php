<?php $__env->startSection('title', 'Status'); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-bookmark-check me-1"></i> Status</h5>
        <a href="<?php echo e(route('statuses.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Status</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Nama</th><th>Urutan</th><th>Warna</th><th>Final?</th><th>Jumlah Task</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-medium"><?php echo e($status->name); ?></td>
                        <td><?php echo e($status->order_position); ?></td>
                        <td><span class="badge" style="background-color: <?php echo e($status->color); ?>;">&nbsp;&nbsp;&nbsp;</span></td>
                        <td>
                            <?php if($status->is_final): ?>
                                <span class="badge bg-success-subtle text-success-emphasis">Ya</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">Tidak</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($status->tasks_count); ?></td>
                        <td class="text-end">
                            <a href="<?php echo e(route('statuses.edit', $status)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('statuses.destroy', $status)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada data status.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($statuses->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/statuses/index.blade.php ENDPATH**/ ?>