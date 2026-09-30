<?php

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 200 on index', function () {
    $response = $this->get(route('deals.index'));

    $response->assertStatus(200);
});

it('filters deals by status', function () {
    $client = Client::create(['name' => 'Иван Петров']);
    Deal::create(['client_id' => $client->id, 'title' => 'Сделка 1', 'amount' => 10000, 'status' => 'lead']);
    Deal::create(['client_id' => $client->id, 'title' => 'Сделка 2', 'amount' => 20000, 'status' => 'paid']);

    $response = $this->get(route('deals.index', ['status' => 'lead']));

    $response->assertStatus(200)
        ->assertSee('Сделка 1')
        ->assertDontSee('Сделка 2');
});

it('filters deals by client_id', function () {
    $client1 = Client::create(['name' => 'Иван Петров']);
    $client2 = Client::create(['name' => 'Пётр Иванов']);
    Deal::create(['client_id' => $client1->id, 'title' => 'Сделка 1', 'amount' => 10000, 'status' => 'lead']);
    Deal::create(['client_id' => $client2->id, 'title' => 'Сделка 2', 'amount' => 20000, 'status' => 'lead']);

    $response = $this->get(route('deals.index', ['client_id' => $client1->id]));

    $response->assertStatus(200)
        ->assertSee('Сделка 1')
        ->assertDontSee('Сделка 2');
});

it('updates deal status', function () {
    $client = Client::create(['name' => 'Иван Петров']);
    $deal = Deal::create(['client_id' => $client->id, 'title' => 'Сделка 1', 'amount' => 10000, 'status' => 'lead']);

    $response = $this->post(route('deals.updateStatus', $deal), [
        'status' => 'in_progress',
    ]);

    $response->assertRedirect(route('deals.index'));
    $this->assertDatabaseHas('deals', ['id' => $deal->id, 'status' => 'in_progress']);
});

it('validates status must be from the list', function () {
    $client = Client::create(['name' => 'Иван Петров']);
    $deal = Deal::create(['client_id' => $client->id, 'title' => 'Сделка 1', 'amount' => 10000, 'status' => 'lead']);

    $response = $this->post(route('deals.updateStatus', $deal), [
        'status' => 'invalid_status',
    ]);

    $response->assertSessionHasErrors('status');
});
