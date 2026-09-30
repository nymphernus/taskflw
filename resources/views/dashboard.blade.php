@extends('layouts.app')

@section('title', __('app.dashboard') . ' — ' . __('app.title'))

@section('content')
<h1 class="mb-4">{{ __('app.dashboard') }}</h1>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('app.clients') }}</h5>
                <p class="card-text display-6">{{ $clientsCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('app.active_deals') }}</h5>
                <p class="card-text display-6">{{ $activeDealsCount }}</p>
                <p class="card-text">{{ number_format($activeDealsSum, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('app.expected_revenue') }}</h5>
                <p class="card-text display-6">{{ number_format($expectedRevenue, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('app.paid_total') }}</h5>
                <p class="card-text display-6">{{ number_format($paidTotal, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <h3>{{ __('app.deals_by_status') }}</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('app.status') }}</th>
                    <th>{{ __('app.count') }}</th>
                    <th>{{ __('app.sum') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dealsByStatus as $status => $data)
                    <tr>
                        <td>{{ $data['label'] }}</td>
                        <td>{{ $data['count'] }}</td>
                        <td>{{ number_format($data['sum'], 0, ',', ' ') }} ₽</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3>{{ __('app.upcoming_deadlines') }}</h3>
        @if($upcomingTasks->isEmpty())
            <p>{{ __('app.no_results') }}</p>
        @else
            <div class="list-group">
                @foreach($upcomingTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>{{ $task->title }}</span>
                        <span class="badge bg-primary rounded-pill">{{ $task->due_date->format('d.m.Y') }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

<h3>{{ __('app.recent_interactions') }}</h3>
@if($recentInteractions->isEmpty())
    <p>{{ __('app.no_results') }}</p>
@else
    <ul class="list-group">
        @foreach($recentInteractions as $interaction)
            <li class="list-group-item">
                <a href="{{ route('clients.show', $interaction->client) }}">{{ $interaction->client->name }}</a> —
                {{ \App\Models\Interaction::TYPES[$interaction->type] ?? $interaction->type }}:
                {{ $interaction->description }}
                <small class="text-muted">{{ $interaction->happened_at->format('d.m.Y H:i') }}</small>
            </li>
        @endforeach
    </ul>
@endif
@overwrite
