@extends('layouts.app')

@section('title', __('app.new_deal') . ' — ' . __('app.title'))

@section('content')
<h1 class="mb-4">{{ __('app.new_deal') }}</h1>

<form method="POST" action="{{ route('deals.store') }}">
    @csrf
    <div class="mb-3">
        <label for="client_id" class="form-label">{{ __('app.client') }} *</label>
        <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @endif">
            <option value="">{{ __('app.select_client') }}</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ old('client_id', $selectedClient) == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
            @endforeach
        </select>
        @error('client_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">{{ __('app.title_field') }} *</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @endif" value="{{ old('title') }}">
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">{{ __('app.amount') }} *</label>
        <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @endif" value="{{ old('amount') }}" step="0.01" min="0">
        @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">{{ __('app.status') }} *</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @endif">
            @foreach(\App\Models\Deal::STATUSES as $key => $label)
                <option value="{{ $key }}" {{ old('status', 'lead') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">{{ __('app.notes') }}</label>
        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @endif" rows="3">{{ old('notes') }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    <a href="{{ route('deals.index') }}" class="btn btn-secondary">{{ __('app.cancel') }}</a>
</form>
@overwrite
