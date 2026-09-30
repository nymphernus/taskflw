<?php

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 200 on index', function () {
    $response = $this->get(route('dashboard'));

    $response->assertStatus(200);
});

it('shows correct client count', function () {
    Client::create(['name' => 'Иван Петров']);
    Client::create(['name' => 'Пётр Иванов']);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertSee('2');
});

it('shows correct expected revenue sum', function () {
    $client = Client::create(['name' => 'Иван Петров']);
    Deal::create(['client_id' => $client->id, 'title' => 'Сделка 1', 'amount' => 50000, 'status' => 'in_progress']);
    Deal::create(['client_id' => $client->id, 'title' => 'Сделка 2', 'amount' => 30000, 'status' => 'in_progress']);
    Deal::create(['client_id' => $client->id, 'title' => 'Сделка 3', 'amount' => 100000, 'status' => 'paid']);

    $response = $this->get(route('dashboard'));

    $response->assertStatus(200)
        ->assertSee('80 000')
        ->assertDontSee('180 000');
});
