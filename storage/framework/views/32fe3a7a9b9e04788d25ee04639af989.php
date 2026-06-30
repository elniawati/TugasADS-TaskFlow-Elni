<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Total Task</div>
                <div class="fs-3 fw-bold"><?php echo e($totalTasks); ?></div>
                <i class="bi bi-list-task text-primary"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Selesai</div>
                <div class="fs-3 fw-bold text-success"><?php echo e($completedTasks); ?></div>
                <i class="bi bi-check-circle text-success"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Belum Selesai</div>
                <div class="fs-3 fw-bold text-warning"><?php echo e($pendingTasks); ?></div>
                <i class="bi bi-hourglass-split text-warning"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Overdue</div>
                <div class="fs-3 fw-bold text-danger"><?php echo e($overdueTasks); ?></div>
                <i class="bi bi-exclamation-triangle text-danger"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Hari Ini</div>
                <div class="fs-3 fw-bold"><?php echo e($todayTasks); ?></div>
                <i class="bi bi-calendar-day text-info"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Bulan Ini</div>
                <div class="fs-3 fw-bold"><?php echo e($monthTasks); ?></div>
                <i class="bi bi-calendar-month text-secondary"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3">Task per Kategori</h6>
                <canvas id="categoryChart" height="220"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3">Task per Prioritas</h6>
                <canvas id="priorityChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3"><i class="bi bi-calendar-event me-1"></i> Deadline Terdekat</h6>
                <?php $__empty_1 = true; $__currentLoopData = $upcomingDeadlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <a href="<?php echo e(route('tasks.show', $task)); ?>" class="text-decoration-none fw-medium"><?php echo e($task->title); ?></a>
                            <div class="small text-secondary"><?php echo e($task->category->name); ?> &middot; <?php echo e($task->status->name); ?></div>
                        </div>
                        <span class="badge badge-soft" style="background-color: <?php echo e($task->priority->color); ?>22; color: <?php echo e($task->priority->color); ?>;">
                            <?php echo e($task->deadline->format('d M Y')); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-secondary small mb-0">Tidak ada deadline terdekat.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3"><i class="bi bi-activity me-1"></i> Aktivitas Terbaru</h6>
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex gap-2 border-bottom py-2">
                        <i class="bi bi-dot fs-4 text-primary"></i>
                        <div>
                            <div class="small">
                                <strong><?php echo e($log->user->name ?? 'Sistem'); ?></strong> <?php echo e($log->description); ?>

                            </div>
                            <div class="text-secondary" style="font-size: .75rem;"><?php echo e($log->created_at->diffForHumans()); ?></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-secondary small mb-0">Belum ada aktivitas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($tasksByCategory->pluck('name'), 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($tasksByCategory->pluck('tasks_count'), 15, 512) ?>,
                backgroundColor: <?php echo json_encode($tasksByCategory->pluck('color'), 15, 512) ?>,
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('priorityChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tasksByPriority->pluck('name'), 15, 512) ?>,
            datasets: [{
                label: 'Jumlah Task',
                data: <?php echo json_encode($tasksByPriority->pluck('tasks_count'), 15, 512) ?>,
                backgroundColor: <?php echo json_encode($tasksByPriority->pluck('color'), 15, 512) ?>,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Ridwan Taufik\TaskFlow-Laravel12\TaskFlow-Laravel12\resources\views/dashboard/index.blade.php ENDPATH**/ ?>