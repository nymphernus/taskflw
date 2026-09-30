<?php

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an interaction with valid data', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    $response = $this->post(route('interactions.store', $client), [
        'type'        => 'call',
        'description' => 'Обсудили проект',
        'happened_at' => '2026-01-15 10:00:00',
    ]);

    $response->assertRedirect(route('clients.show', $client));
    $this->assertDatabaseHas('interactions', [
        'client_id'   => $client->id,
        'type'        => 'call',
        'description' => 'Обсудили проект',
    ]);
});

it('validates type must be from the list', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    $response = $this->post(route('interactions.store', $client), [
        'type'        => 'invalid_type',
        'description' => 'Описание',
        'happened_at' => '2026-01-15 10:00:00',
    ]);

    $response->assertSessionHasErrors('type');
});
