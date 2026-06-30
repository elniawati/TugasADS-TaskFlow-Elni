<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $baseQuery = Task::query()->ownedBy($user);

        $totalTasks = (clone $baseQuery)->count();
        $completedTasks = (clone $baseQuery)->whereHas('status', fn ($q) => $q->where('slug', 'completed'))->count();
        $pendingTasks = $totalTasks - $completedTasks;
        $overdueTasks = (clone $baseQuery)
            ->whereDate('deadline', '<', now())
            ->whereHas('status', fn ($q) => $q->where('is_final', false))
            ->count();
        $todayTasks = (clone $baseQuery)->whereDate('deadline', now())->count();
        $weekTasks = (clone $baseQuery)->whereBetween('deadline', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthTasks = (clone $baseQuery)->whereMonth('deadline', now()->month)->whereYear('deadline', now()->year)->count();

        $tasksByCategory = Category::query()
            ->withCount(['tasks' => fn ($q) => $q->ownedBy($user)])
            ->orderByDesc('tasks_count')
            ->get();

        $tasksByPriority = Priority::query()
            ->withCount(['tasks' => fn ($q) => $q->ownedBy($user)])
            ->orderBy('level')
            ->get();

        $upcomingDeadlines = (clone $baseQuery)
            ->with(['category', 'priority', 'status'])
            ->whereHas('status', fn ($q) => $q->where('is_final', false))
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        $recentActivities = $user->isAdmin()
            ? \App\Models\ActivityLog::with('user', 'task')->latest()->limit(8)->get()
            : $user->activityLogs()->with('task')->latest()->limit(8)->get();

        return view('dashboard.index', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'overdueTasks',
            'todayTasks',
            'weekTasks',
            'monthTasks',
            'tasksByCategory',
            'tasksByPriority',
            'upcomingDeadlines',
            'recentActivities',
        ));
    }
}
