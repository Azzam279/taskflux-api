<?php

namespace Tests\Feature;

use Tests\TestCase;

class TaskTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Mock bearer header used by the middleware
        $this->withHeader('Authorization', 'Bearer ' . env('MOCK_TOKEN', 'taskflux_dev_token'));
    }

    public function test_crud_flow(): void
    {
        // Create
        $create = $this->postJson('/api/tasks', [
            'title'    => 'Test Task',
            'status'   => 'todo',
            'priority' => 'medium',
        ]);
        $create->assertCreated();
        $create->assertJsonStructure(['title', 'status', 'priority', 'ownerId', 'created_at', 'updated_at']);

        // List
        $list = $this->getJson('/api/tasks?status=todo&sort=-created_at&page=1&per_page=5');
        $list->assertOk()
             ->assertJsonStructure([
                 'data',
                 'meta' => ['page','per_page','total','last_page','sort'],
             ]);
        $id = $list->json('data.0')['id'];

        // Update
        $update = $this->putJson("/api/tasks/{$id}", [
            'status'   => 'doing',
            'priority' => 'high',
        ]);
        $update->assertOk()
               ->assertJsonPath('status', 'doing')
               ->assertJsonPath('priority', 'high');

        // Delete
        $this->deleteJson("/api/tasks/{$id}")->assertNoContent();
    }
}
