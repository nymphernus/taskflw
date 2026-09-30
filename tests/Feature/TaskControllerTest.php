<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('toggles task status from open to done and back', function () {
    $task = Task::create(['title' => 'Тестовая задача', 'status' => 'open']);

    $this->post(route('tasks.toggle', $task));
    $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done']);

    $this->post(route('tasks.toggle', $task));
    $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'open']);
});

it('filters tasks by status', function () {
    Task::create(['title' => 'Задача 1', 'status' => 'open']);
    Task::create(['title' => 'Задача 2', 'status' => 'done']);

    $response = $this->get(route('tasks.index', ['status' => 'open']));

    $response->assertStatus(200)
        ->assertSee('Задача 1')
        ->assertDontSee('Задача 2');
});

it('sorts open tasks first', function () {
    Task::create(['title' => 'Задача done', 'status' => 'done', 'due_date' => '2026-01-10']);
    Task::create(['title' => 'Задача open', 'status' => 'open', 'due_date' => '2026-01-15']);

    $response = $this->get(route('tasks.index'));

    $response->assertStatus(200);
    $content = $response->getContent();
    $openPos = strpos($content, 'Задача open');
    $donePos = strpos($content, 'Задача done');
    expect($openPos)->toBeLessThan($donePos);
});

it('task show page displays task details', function () {
    $task = Task::create([
        'title'       => 'Тестовая задача',
        'description' => 'Описание задачи',
        'status'      => 'open',
        'due_date'    => '2026-01-15',
    ]);

    $response = $this->get(route('tasks.show', $task));

    $response->assertStatus(200)
        ->assertSee('Тестовая задача')
        ->assertSee('Описание задачи');
});
