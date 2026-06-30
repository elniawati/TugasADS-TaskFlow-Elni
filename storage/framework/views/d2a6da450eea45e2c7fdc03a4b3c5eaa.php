<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'TaskFlow')); ?> - <?php echo $__env->yieldContent('title', 'Login'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        .auth-card { border-radius: 1rem; box-shadow: 0 1rem 3rem rgba(0,0,0,.15); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4 text-white">
                    <h2><i class="bi bi-kanban-fill"></i> TaskFlow</h2>
                    <p class="text-white-50 mb-0">Sistem Informasi Manajemen Tugas</p>
                </div>
                <div class="card auth-card border-0">
                    <div class="card-body p-4 p-md-5">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/layouts/guest.blade.php ENDPATH**/ ?>