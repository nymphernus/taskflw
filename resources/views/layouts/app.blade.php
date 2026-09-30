<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-bs-theme="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('favicon.svg') }}" alt="" width="28" height="28">
            <span>{{ config('app.name') }}</span>
        </a>
        <div class="navbar-nav me-auto">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('app.dashboard') }}</a>
            <a class="nav-link" href="{{ route('clients.index') }}">{{ __('app.clients') }}</a>
            <a class="nav-link" href="{{ route('deals.index') }}">{{ __('app.deals') }}</a>
            <a class="nav-link" href="{{ route('tasks.index') }}">{{ __('app.tasks') }}</a>
        </div>
        <div class="d-flex gap-2">
            <a href="?lang={{ app()->getLocale() === 'ru' ? 'en' : 'ru' }}"
               class="btn btn-sm btn-outline-light">
                {{ app()->getLocale() === 'ru' ? 'EN' : 'RU' }}
            </a>
            <a href="?theme={{ session('theme', 'light') === 'light' ? 'dark' : 'light' }}"
               class="btn btn-sm btn-outline-light">
                {{ session('theme', 'light') === 'light' ? '🌙' : '☀️' }}
            </a>
        </div>
    </div>
</nav>

<main class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
