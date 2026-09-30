@extends('layouts.app')

@section('title', __('app.edit_client') . ' — ' . __('app.title'))

@section('content')
<h1 class="mb-4">{{ __('app.edit_client') }}</h1>

<form method="POST" action="{{ route('clients.update', $client) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('app.name') }} *</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @endif" value="{{ old('name', $client->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="company" class="form-label">{{ __('app.company') }}</label>
        <input type="text" name="company" id="company" class="form-control @error('company') is-invalid @endif" value="{{ old('company', $client->company) }}">
        @error('company')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('app.email') }}</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @endif" value="{{ old('email', $client->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">{{ __('app.phone') }}</label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @endif" value="{{ old('phone', $client->phone) }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">{{ __('app.notes') }}</label>
        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @endif" rows="3">{{ old('notes', $client->notes) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
</form>
@overwrite
