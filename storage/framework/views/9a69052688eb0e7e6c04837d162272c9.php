<?php $__env->startSection('title', 'User'); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-people me-1"></i> Manajemen User</h5>
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah User</a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / email..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-3">
            <select name="role_id" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e(request('role_id') == $role->id ? 'selected' : ''); ?>><?php echo e($role->label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Role</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-medium"><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->phone ?? '-'); ?></td>
                        <td>
                            <span class="badge <?php echo e($user->isAdmin() ? 'bg-primary-subtle text-primary-emphasis' : 'bg-secondary-subtle text-secondary-emphasis'); ?>">
                                <?php echo e($user->role->label ?? '-'); ?>

                            </span>
                        </td>
                        <td class="text-end">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <?php if($user->id !== auth()->id()): ?>
                                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data user.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/users/index.blade.php ENDPATH**/ ?>