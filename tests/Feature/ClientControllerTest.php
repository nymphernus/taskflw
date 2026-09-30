<?php

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 200 and lists clients on index', function () {
    Client::create(['name' => 'Иван Петров']);

    $response = $this->get(route('clients.index'));

    $response->assertStatus(200)
        ->assertSee('Иван Петров');
});

it('creates a client with valid data and redirects', function () {
    $response = $this->post(route('clients.store'), [
        'name'    => 'Иван Петров',
        'company' => 'ООО "Ромашка"',
        'email'   => 'ivan@example.com',
        'phone'   => '+7 999 123-45-67',
        'notes'   => 'Важный клиент',
    ]);

    $response->assertRedirect(route('clients.show', 1));
    $this->assertDatabaseHas('clients', ['name' => 'Иван Петров']);
});

it('returns validation errors when name is empty', function () {
    $response = $this->post(route('clients.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors('name');
});

it('shows a client on show page', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    $response = $this->get(route('clients.show', $client));

    $response->assertStatus(200)
        ->assertSee('Иван Петров');
});

it('updates a client', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    $response = $this->put(route('clients.update', $client), [
        'name' => 'Пётр Иванов',
    ]);

    $response->assertRedirect(route('clients.show', $client));
    $this->assertDatabaseHas('clients', ['name' => 'Пётр Иванов']);
});

it('deletes a client', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    $response = $this->delete(route('clients.destroy', $client));

    $response->assertRedirect(route('clients.index'));
    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
});

it('finds a client by name search', function () {
    Client::create(['name' => 'Иван Петров']);
    Client::create(['name' => 'Пётр Сидоров']);

    $response = $this->get(route('clients.index', ['search' => 'Иван']));

    $response->assertStatus(200)
        ->assertSee('Иван Петров')
        ->assertDontSee('Пётр Сидоров');
});
