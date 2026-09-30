@extends('layouts.app')

@section('title', __('app.edit_task') . ' — ' . __('app.title'))

@section('content')
<h1 class="mb-4">{{ __('app.edit_task') }}</h1>

<form method="POST" action="{{ route('tasks.update', $task) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="client_id" class="form-label">{{ __('app.client') }}</label>
        <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @endif">
            <option value="">{{ __('app.no_client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $task->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
            @endforeach
        </select>
        @error('client_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">{{ __('app.title_field') }} *</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @endif" value="{{ old('title', $task->title) }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">{{ __('app.description') }}</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @endif" rows="3">{{ old('description', $task->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="due_date" class="form-label">{{ __('app.due_date') }}</label>
        <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @endif" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
        @error('due_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">{{ __('app.status') }} *</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @endif">
            @foreach(\App\Models\Task::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ old('status', $task->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
</form>
@overwrite
