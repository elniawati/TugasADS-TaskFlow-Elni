@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Total Task</div>
                <div class="fs-3 fw-bold">{{ $totalTasks }}</div>
                <i class="bi bi-list-task text-primary"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Selesai</div>
                <div class="fs-3 fw-bold text-success">{{ $completedTasks }}</div>
                <i class="bi bi-check-circle text-success"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Belum Selesai</div>
                <div class="fs-3 fw-bold text-warning">{{ $pendingTasks }}</div>
                <i class="bi bi-hourglass-split text-warning"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Overdue</div>
                <div class="fs-3 fw-bold text-danger">{{ $overdueTasks }}</div>
                <i class="bi bi-exclamation-triangle text-danger"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Hari Ini</div>
                <div class="fs-3 fw-bold">{{ $todayTasks }}</div>
                <i class="bi bi-calendar-day text-info"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card stat-card p-3 h-100">
                <div class="text-secondary small">Bulan Ini</div>
                <div class="fs-3 fw-bold">{{ $monthTasks }}</div>
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
                @forelse($upcomingDeadlines as $task)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-medium">{{ $task->title }}</a>
                            <div class="small text-secondary">{{ $task->category->name }} &middot; {{ $task->status->name }}</div>
                        </div>
                        <span class="badge badge-soft" style="background-color: {{ $task->priority->color }}22; color: {{ $task->priority->color }};">
                            {{ $task->deadline->format('d M Y') }}
                        </span>
                    </div>
                @empty
                    <p class="text-secondary small mb-0">Tidak ada deadline terdekat.</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h6 class="mb-3"><i class="bi bi-activity me-1"></i> Aktivitas Terbaru</h6>
                @forelse($recentActivities as $log)
                    <div class="d-flex gap-2 border-bottom py-2">
                        <i class="bi bi-dot fs-4 text-primary"></i>
                        <div>
                            <div class="small">
                                <strong>{{ $log->user->name ?? 'Sistem' }}</strong> {{ $log->description }}
                            </div>
                            <div class="text-secondary" style="font-size: .75rem;">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary small mb-0">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($tasksByCategory->pluck('name')),
            datasets: [{
                data: @json($tasksByCategory->pluck('tasks_count')),
                backgroundColor: @json($tasksByCategory->pluck('color')),
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('priorityChart'), {
        type: 'bar',
        data: {
            labels: @json($tasksByPriority->pluck('name')),
            datasets: [{
                label: 'Jumlah Task',
                data: @json($tasksByPriority->pluck('tasks_count')),
                backgroundColor: @json($tasksByPriority->pluck('color')),
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
</script>
@endpush
