@extends('layouts.app')

@section('title', $client->name . ' — ' . __('app.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $client->name }}</h1>
    <div>
        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">{{ __('app.edit') }}</a>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">{{ __('app.back_to_clients') }}</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>{{ __('app.company') }}:</strong> {{ $client->company }}</p>
        <p><strong>{{ __('app.email') }}:</strong> {{ $client->email }}</p>
        <p><strong>{{ __('app.phone') }}:</strong> {{ $client->phone }}</p>
        <p><strong>{{ __('app.notes') }}:</strong> {{ $client->notes }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>{{ __('app.deals') }}</h3>
        <a href="{{ route('deals.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-primary mb-2">{{ __('app.add_deal') }}</a>
        @if($client->deals->isEmpty())
            <p>{{ __('app.no_results') }}</p>
        @else
            <ul class="list-group">
                @foreach($client->deals as $deal)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $deal->title }} — {{ number_format($deal->amount, 0, ',', ' ') }} ₽</span>
                        <span class="badge bg-secondary">{{ \App\Models\Deal::STATUSES[$deal->status] ?? $deal->status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="col-md-6">
        <h3>{{ __('app.tasks') }}</h3>
        <a href="{{ route('tasks.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-primary mb-2">{{ __('app.add_task') }}</a>
        @if($client->tasks->isEmpty())
            <p>{{ __('app.no_results') }}</p>
        @else
            <ul class="list-group">
                @foreach($client->tasks as $task)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $task->title }}</span>
                        <span class="badge bg-{{ $task->status === 'open' ? 'warning' : 'success' }}">{{ \App\Models\Task::STATUSES[$task->status] ?? $task->status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<h3 class="mt-4">{{ __('app.interactions') }}</h3>
<form method="POST" action="{{ route('interactions.store', $client) }}" class="mb-3">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <select name="type" class="form-select @error('type') is-invalid @endif">
                @foreach(\App\Models\Interaction::TYPES as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @endif
        </div>
        <div class="col-md-4">
            <input type="text" name="description" class="form-control @error('description') is-invalid @endif" placeholder="{{ __('app.description') }}">
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @endif
        </div>
        <div class="col-md-3">
            <input type="datetime-local" name="happened_at" class="form-control @error('happened_at') is-invalid @endif">
            @error('happened_at')
                <div class="invalid-feedback">{{ $message }}</div>
            @endif
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">{{ __('app.add') }}</button>
        </div>
    </div>
</form>

@if($client->interactions->isEmpty())
    <p>{{ __('app.no_results') }}</p>
@else
    <ul class="list-group">
        @foreach($client->interactions as $interaction)
            <li class="list-group-item">
                <strong>{{ \App\Models\Interaction::TYPES[$interaction->type] ?? $interaction->type }}</strong>:
                {{ $interaction->description }}
                <small class="text-muted">{{ $interaction->happened_at->format('d.m.Y H:i') }}</small>
                <form method="POST" action="{{ route('interactions.destroy', $interaction) }}" class="d-inline float-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('app.delete') }}</button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
@overwrite
