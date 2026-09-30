@extends('layouts.app')

@section('title', __('app.tasks') . ' — ' . __('app.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ __('app.tasks') }}</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">{{ __('app.new_task') }}</a>
</div>

<form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">{{ __('app.all_statuses') }}</option>
                @foreach(\App\Models\Task::STATUSES as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="client_id" class="form-select">
                <option value="">{{ __('app.all_clients') }}</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-secondary">{{ __('app.filter') }}</button>
        </div>
    </div>
</form>

@if($tasks->isEmpty())
    <p>{{ __('app.no_results') }}</p>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.title_field') }}</th>
                <th>{{ __('app.client') }}</th>
                <th>{{ __('app.due_date') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>
                        <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                            @csrf
                            <div class="form-check">
                                <input type="checkbox" name="toggle" class="form-check-input" onchange="this.form.submit()" {{ $task->status === 'done' ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->client->name ?? '—' }}</td>
                    <td>{{ $task->due_date?->format('d.m.Y') ?? '—' }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('app.confirm_delete') }}')">{{ __('app.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
@endif
@overwrite
