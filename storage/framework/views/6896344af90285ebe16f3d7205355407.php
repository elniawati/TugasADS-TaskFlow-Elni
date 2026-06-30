<?php $__env->startSection('title', 'Task'); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-list-task me-1"></i> Daftar Task</h5>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('tasks.export.pdf', request()->query())); ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
            <a href="<?php echo e(route('tasks.export.excel', request()->query())); ?>" class="btn btn-outline-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
            <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Task</a>
        </div>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul task..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority_id" class="form-select form-select-sm">
                <option value="">Semua Prioritas</option>
                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($priority->id); ?>" <?php echo e(request('priority_id') == $priority->id ? 'selected' : ''); ?>><?php echo e($priority->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status_id" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status->id); ?>" <?php echo e(request('status_id') == $status->id ? 'selected' : ''); ?>><?php echo e($status->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control form-control-sm" value="<?php echo e(request('date_from')); ?>" title="Dari tanggal">
        </div>
        <div class="col-md-1">
            <button class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th><a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="text-decoration-none text-dark">Judul <i class="bi bi-arrow-down-up small"></i></a></th>
                    <?php if(auth()->user()->isAdmin()): ?><th>Pemilik</th><?php endif; ?>
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th><a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'deadline', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])); ?>" class="text-decoration-none text-dark">Deadline <i class="bi bi-arrow-down-up small"></i></a></th>
                    <th>Lampiran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('tasks.show', $task)); ?>" class="text-decoration-none fw-medium"><?php echo e($task->title); ?></a>
                            <?php if($task->isOverdue()): ?>
                                <span class="badge bg-danger-subtle text-danger-emphasis ms-1">Overdue</span>
                            <?php endif; ?>
                        </td>
                        <?php if(auth()->user()->isAdmin()): ?><td><?php echo e($task->user->name); ?></td><?php endif; ?>
                        <td><span class="badge badge-soft" style="background-color: <?php echo e($task->category->color); ?>22; color: <?php echo e($task->category->color); ?>;"><?php echo e($task->category->name); ?></span></td>
                        <td><span class="badge badge-soft" style="background-color: <?php echo e($task->priority->color); ?>22; color: <?php echo e($task->priority->color); ?>;"><?php echo e($task->priority->name); ?></span></td>
                        <td>
                            <form action="<?php echo e(route('tasks.status', $task)); ?>" method="POST">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <select name="status_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:130px;">
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>" <?php echo e($task->status_id == $status->id ? 'selected' : ''); ?>><?php echo e($status->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </td>
                        <td><?php echo e($task->deadline->format('d M Y')); ?></td>
                        <td>
                            <?php if($task->files->count()): ?>
                                <span class="badge bg-secondary-subtle text-secondary-emphasis"><i class="bi bi-paperclip"></i> <?php echo e($task->files->count()); ?></span>
                            <?php else: ?>
                                <span class="text-secondary small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?php echo e(route('tasks.show', $task)); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?php echo e(route('tasks.destroy', $task)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada data task.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($tasks->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/tasks/index.blade.php ENDPATH**/ ?>