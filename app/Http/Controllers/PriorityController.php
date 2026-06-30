<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriorityRequest;
use App\Models\Priority;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriorityController extends Controller
{
    public function index(Request $request): View
    {
        $priorities = Priority::query()
            ->withCount('tasks')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            })
            ->orderBy($request->get('sort', 'level'), $request->get('direction', 'asc'))
            ->paginate(10)
            ->withQueryString();

        return view('priorities.index', compact('priorities'));
    }

    public function create(): View
    {
        return view('priorities.create');
    }

    public function store(PriorityRequest $request): RedirectResponse
    {
        Priority::create($request->validated());

        return redirect()->route('priorities.index')->with('success', 'Prioritas berhasil ditambahkan.');
    }

    public function edit(Priority $priority): View
    {
        return view('priorities.edit', compact('priority'));
    }

    public function update(PriorityRequest $request, Priority $priority): RedirectResponse
    {
        $priority->update($request->validated());

        return redirect()->route('priorities.index')->with('success', 'Prioritas berhasil diperbarui.');
    }

    public function destroy(Priority $priority): RedirectResponse
    {
        if ($priority->tasks()->exists()) {
            return back()->with('error', 'Prioritas tidak dapat dihapus karena masih digunakan oleh task.');
        }

        $priority->delete();

        return redirect()->route('priorities.index')->with('success', 'Prioritas berhasil dihapus.');
    }
}
