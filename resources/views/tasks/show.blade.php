@extends('layouts.app')

@section('title', $task->title . ' — ' . __('app.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $task->title }}</h1>
    <div>
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">{{ __('app.edit') }}</a>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('app.back_to_tasks') }}</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>{{ __('app.status') }}:</strong> {{ \App\Models\Task::STATUSES[$task->status] ?? $task->status }}</p>
        <p><strong>{{ __('app.client') }}:</strong>
            @if($task->client)
                <a href="{{ route('clients.show', $task->client) }}">{{ $task->client->name }}</a>
            @else
                —
            @endif
        </p>
        <p><strong>{{ __('app.due_date') }}:</strong> {{ $task->due_date?->format('d.m.Y') ?? '—' }}</p>
        <p><strong>{{ __('app.description') }}:</strong> {{ $task->description }}</p>
    </div>
</div>

@if($task->status === 'open')
    <form method="POST" action="{{ route('tasks.toggle', $task) }}">
        @csrf
        <div class="form-check">
            <input type="checkbox" name="toggle" class="form-check-input" onchange="this.form.submit()">
            <label class="form-check-label">{{ __('app.mark_as_done') }}</label>
        </div>
    </form>
@endif
@overwrite
