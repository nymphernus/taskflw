<?php

use App\Models\Client;
use App\Models\Deal;
use App\Models\Interaction;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a client with filled fields', function () {
    $client = Client::create([
        'name'    => 'Иван Петров',
        'company' => 'ООО "Ромашка"',
        'email'   => 'ivan@example.com',
        'phone'   => '+7 999 123-45-67',
        'notes'   => 'Важный клиент',
    ]);

    expect($client)->toBeInstanceOf(Client::class)
        ->and($client->name)->toBe('Иван Петров')
        ->and($client->company)->toBe('ООО "Ромашка"')
        ->and($client->email)->toBe('ivan@example.com')
        ->and($client->phone)->toBe('+7 999 123-45-67')
        ->and($client->notes)->toBe('Важный клиент');
});

it('requires a name to create a client', function () {
    Client::create([
        'company' => 'ООО "Ромашка"',
        'email'   => 'ivan@example.com',
    ]);
})->throws(\Illuminate\Database\QueryException::class);

it('has many deals', function () {
    $client = Client::create(['name' => 'Иван Петров']);

    expect($client->deals())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

it('has four deal statuses', function () {
    expect(Deal::STATUSES)->toHaveCount(4)
        ->toHaveKeys(['lead', 'in_progress', 'paid', 'rejected']);
});

it('has four interaction types', function () {
    expect(Interaction::TYPES)->toHaveCount(4)
        ->toHaveKeys(['call', 'email', 'meeting', 'other']);
});

it('has two task statuses', function () {
    expect(Task::STATUSES)->toHaveCount(2)
        ->toHaveKeys(['open', 'done']);
});

it('cascades delete to deals', function () {
    $client = Client::create(['name' => 'Иван Петров']);
    $deal = Deal::create([
        'client_id' => $client->id,
        'title'     => 'Тестовая сделка',
        'amount'    => 10000,
        'status'    => 'lead',
    ]);

    $client->delete();

    expect(Deal::find($deal->id))->toBeNull();
});

it('creates a task with null client_id', function () {
    $task = Task::create([
        'title'       => 'Общая задача',
        'description' => 'Описание',
        'status'      => 'open',
    ]);

    expect($task)->toBeInstanceOf(Task::class)
        ->and($task->client_id)->toBeNull();
});
