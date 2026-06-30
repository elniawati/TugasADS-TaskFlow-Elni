<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function index(Request $request): View
    {
        $statuses = Status::query()
            ->withCount('tasks')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            })
            ->orderBy($request->get('sort', 'order_position'), $request->get('direction', 'asc'))
            ->paginate(10)
            ->withQueryString();

        return view('statuses.index', compact('statuses'));
    }

    public function create(): View
    {
        return view('statuses.create');
    }

    public function store(StatusRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_final'] = $request->boolean('is_final');

        Status::create($data);

        return redirect()->route('statuses.index')->with('success', 'Status berhasil ditambahkan.');
    }

    public function edit(Status $status): View
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(StatusRequest $request, Status $status): RedirectResponse
    {
        $data = $request->validated();
        $data['is_final'] = $request->boolean('is_final');

        $status->update($data);

        return redirect()->route('statuses.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(Status $status): RedirectResponse
    {
        if ($status->tasks()->exists()) {
            return back()->with('error', 'Status tidak dapat dihapus karena masih digunakan oleh task.');
        }

        $status->delete();

        return redirect()->route('statuses.index')->with('success', 'Status berhasil dihapus.');
    }
}
