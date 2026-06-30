<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Task</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #222; }
        h2 { margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ccc; padding: 5px 7px; text-align: left; }
        th { background: #f1f1f1; }
        .text-muted { color: #777; font-size: 10px; }
    </style>
</head>
<body>
    <h2>Laporan Task - TaskFlow</h2>
    <p class="text-muted">Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pemilik</th>
                <th>Kategori</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $i => $task)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->category->name }}</td>
                    <td>{{ $task->priority->name }}</td>
                    <td>{{ $task->status->name }}</td>
                    <td>{{ $task->deadline->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
