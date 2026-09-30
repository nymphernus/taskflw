@extends('layouts.app')

@section('title', __('app.deals') . ' — ' . __('app.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ __('app.deals') }}</h1>
    <a href="{{ route('deals.create') }}" class="btn btn-primary">{{ __('app.new_deal') }}</a>
</div>

<form method="GET" action="{{ route('deals.index') }}" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">{{ __('app.all_statuses') }}</option>
                @foreach(\App\Models\Deal::STATUSES as $key => $label)
                    <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="client_id" class="form-select">
                <option value="">{{ __('app.all_clients') }}</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="amount_from" class="form-control" placeholder="{{ __('app.amount_from') }}" value="{{ request('amount_from') }}">
        </div>
        <div class="col-md-2">
            <input type="number" name="amount_to" class="form-control" placeholder="{{ __('app.amount_to') }}" value="{{ request('amount_to') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-secondary">{{ __('app.filter') }}</button>
        </div>
    </div>
</form>

@if($deals->isEmpty())
    <p>{{ __('app.no_results') }}</p>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('app.title_field') }}</th>
                <th>{{ __('app.client') }}</th>
                <th>{{ __('app.amount') }}</th>
                <th>{{ __('app.status') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deals as $deal)
                <tr>
                    <td>{{ $deal->title }}</td>
                    <td>{{ $deal->client->name }}</td>
                    <td>{{ number_format($deal->amount, 0, ',', ' ') }} ₽</td>
                    <td>
                        <form method="POST" action="{{ route('deals.updateStatus', $deal) }}">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach(\App\Models\Deal::STATUSES as $key => $label)
                                    <option value="{{ $key }}" {{ $deal->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('deals.edit', $deal) }}" class="btn btn-sm btn-warning">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('deals.destroy', $deal) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('app.confirm_delete') }}')">{{ __('app.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $deals->links() }}
@endif
@overwrite
