<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $query = Task::query()->with('client');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        $query->orderByRaw("CASE WHEN status = 'open' THEN 0 ELSE 1 END")
            ->orderByRaw("due_date IS NULL")
            ->orderBy('due_date');

        $tasks = $query->paginate(20);
        $clients = Client::orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'clients'));
    }

    public function create(Request $request): View
    {
        $clients = Client::orderBy('name')->get();
        $selectedClient = $request->input('client_id');

        return view('tasks.create', compact('clients', 'selectedClient'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'client_id'   => 'nullable|exists:clients,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'required|in:open,done',
        ]);

        $task = Task::create($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Задача создана');
    }

    public function edit(Task $task): View
    {
        $clients = Client::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'clients'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $data = $request->validate([
            'client_id'   => 'nullable|exists:clients,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'status'      => 'required|in:open,done',
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Задача обновлена');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Задача удалена');
    }

    public function toggle(Task $task): RedirectResponse
    {
        $task->update([
            'status' => $task->status === 'open' ? 'done' : 'open',
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Статус задачи обновлён');
    }

    public function show(Task $task): View
    {
        return view('tasks.show', [
            'task' => $task,
        ]);
    }
}
