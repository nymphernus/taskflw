@extends('layouts.app')

@section('title', __('app.clients') . ' — ' . __('app.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ __('app.clients') }}</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">{{ __('app.new_client') }}</a>
</div>

<form method="GET" action="{{ route('clients.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="{{ __('app.search') }}" value="{{ $search }}">
        <button type="submit" class="btn btn-outline-secondary">{{ __('app.search') }}</button>
    </div>
</form>

@if($clients->isEmpty())
    <p>{{ __('app.no_results') }}</p>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('app.name') }}</th>
                <th>{{ __('app.company') }}</th>
                <th>{{ __('app.email') }}</th>
                <th>{{ __('app.phone') }}</th>
                <th>{{ __('app.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->company }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-info">{{ __('app.open') }}</a>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">{{ __('app.edit') }}</a>
                        <form method="POST" action="{{ route('clients.destroy', $client) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('app.confirm_delete') }}')">{{ __('app.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clients->links() }}
@endif
@overwrite
