<?php $__env->startSection('title', 'Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-tags me-1"></i> Kategori</h5>
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kategori..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Warna</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Task</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-medium"><?php echo e($category->name); ?></td>
                        <td><span class="badge" style="background-color: <?php echo e($category->color); ?>;">&nbsp;&nbsp;&nbsp;</span></td>
                        <td class="text-secondary small"><?php echo e(Str::limit($category->description, 50)); ?></td>
                        <td><?php echo e($category->tasks_count); ?></td>
                        <td class="text-end">
                            <a href="<?php echo e(route('categories.edit', $category)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data kategori.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($categories->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/categories/index.blade.php ENDPATH**/ ?>