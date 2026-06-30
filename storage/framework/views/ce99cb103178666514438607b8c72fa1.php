<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'TaskFlow')); ?> - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f6f9; min-height: 100vh; }
        .sidebar {
            min-height: 100vh; width: 250px; background: #1e293b; position: fixed; top: 0; left: 0;
            transition: margin-left .3s; z-index: 1030;
        }
        .sidebar a { color: #cbd5e1; text-decoration: none; display: block; padding: .65rem 1rem; border-radius: .5rem; margin-bottom: .15rem; }
        .sidebar a.active, .sidebar a:hover { color: #fff; background: #334155; }
        .sidebar .nav-section { color: #64748b; font-size: .72rem; text-transform: uppercase; letter-spacing: .05em; padding: 1rem 1rem .25rem; }
        .main-content { margin-left: 250px; transition: margin-left .3s; min-height: 100vh; }
        @media (max-width: 991.98px) {
            .sidebar { margin-left: -250px; }
            .sidebar.show { margin-left: 0; }
            .main-content { margin-left: 0; }
        }
        .card { border: none; border-radius: .75rem; box-shadow: 0 .125rem .5rem rgba(0,0,0,.06); }
        .stat-card { border-radius: 1rem; }
        .navbar-top { position: sticky; top: 0; z-index: 1020; }
        .badge-soft { padding: .35em .65em; border-radius: .5rem; font-weight: 500; }
        .table thead th { font-size: .8rem; text-transform: uppercase; letter-spacing: .03em; color: #6c757d; border-top: none; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="sidebar p-3 d-flex flex-column" id="sidebar">
        <h5 class="text-white mb-4 px-1"><i class="bi bi-kanban-fill"></i> TaskFlow</h5>

        <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="<?php echo e(route('tasks.index')); ?>" class="<?php echo e(request()->routeIs('tasks.*') ? 'active' : ''); ?>">
            <i class="bi bi-list-task me-2"></i> Task
        </a>

        <?php if(auth()->user()->isAdmin()): ?>
            <div class="nav-section">Master Data</div>
            <a href="<?php echo e(route('categories.index')); ?>" class="<?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
                <i class="bi bi-tags me-2"></i> Kategori
            </a>
            <a href="<?php echo e(route('priorities.index')); ?>" class="<?php echo e(request()->routeIs('priorities.*') ? 'active' : ''); ?>">
                <i class="bi bi-flag me-2"></i> Prioritas
            </a>
            <a href="<?php echo e(route('statuses.index')); ?>" class="<?php echo e(request()->routeIs('statuses.*') ? 'active' : ''); ?>">
                <i class="bi bi-bookmark-check me-2"></i> Status
            </a>
            <a href="<?php echo e(route('users.index')); ?>" class="<?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                <i class="bi bi-people me-2"></i> User
            </a>
        <?php endif; ?>

        <div class="nav-section">Akun</div>
        <a href="<?php echo e(route('profile.edit')); ?>" class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
            <i class="bi bi-person-circle me-2"></i> Profile
        </a>
    </nav>

    <div class="main-content">
        <nav class="navbar navbar-light bg-white shadow-sm px-3 navbar-top">
            <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggle" type="button">
                <i class="bi bi-list"></i>
            </button>

            <nav aria-label="breadcrumb" class="d-none d-md-block">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></li>
                </ol>
            </nav>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-secondary small d-none d-sm-inline">
                    <i class="bi bi-person-badge"></i> <?php echo e(auth()->user()->name); ?>

                    <span class="badge bg-primary-subtle text-primary-emphasis ms-1"><?php echo e(auth()->user()->role->label ?? '-'); ?></span>
                </span>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-sm btn-outline-danger" type="submit">
                        <i class="bi bi-box-arrow-right"></i> <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </nav>

        <main class="p-3 p-md-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });

        document.querySelectorAll('.btn-delete-confirm').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus data ini?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        <?php if(session('success')): ?>
            Swal.fire({ icon: 'success', title: 'Berhasil', text: <?php echo json_encode(session('success'), 15, 512) ?>, timer: 2500, showConfirmButton: false });
        <?php endif; ?>
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/layouts/app.blade.php ENDPATH**/ ?>