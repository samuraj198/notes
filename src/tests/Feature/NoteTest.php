<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_one_note()
    {
        Client::factory(1)->has(Note::factory())->create();

        $response = $this->get('/api/notes/1');

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'client_name',
                'id',
                'content',
                'is_important'
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_get_only_important_notes()
    {
        Client::factory(1)->has(Note::factory(1, ['is_important' => true]))->create();
        Client::factory(1)->has(Note::factory(2, ['is_important' => false]))->create();

        $response = $this->get('/api/important-notes');

        $response->assertJsonStructure([
            'success',
            'message',
            'items' => [
                '*' => [
                    'client_name',
                    'id',
                    'content',
                    'is_important'
                ]
            ]
        ]);

        $this->assertCount(1, $response->json('items'));

        $response->assertStatus(200);
    }

    public function test_store_note()
    {
        $client = Client::factory()->create();

        $data = [
            'content' => 'Test',
            'is_important' => false
        ];

        $this->assertDatabaseMissing('notes', $data);

        $response = $this->post('/api/clients/' . $client->id . '/notes', $data);

        $this->assertDatabaseHas('notes', $data);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'client_name',
                'id',
                'content',
                'is_important'
            ]
        ]);

        $response->assertStatus(201);
    }

    public function test_update_note()
    {
        $client = Client::factory()->has(Note::factory())->create();

        $note = $client->notes->first();

        $data = [
            'content' => 'Test update',
        ];

        $this->assertDatabaseHas('notes', ['content' => $note->content]);

        $response = $this->put('/api/notes/' . $note->id, $data);

        $this->assertDatabaseHas('notes', $data);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'client_name',
                'id',
                'content',
                'is_important'
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_note()
    {
        $client = Client::factory()->has(Note::factory())->create();

        $note = $client->notes->first();

        $this->assertDatabaseHas('notes', ['content' => $note->content, 'deleted_at' => null]);

        $response = $this->delete('/api/notes/' . $note->id);

        $this->assertDatabaseHas('notes', ['content' => $note->content, 'deleted_at' => now()]);

        $response->assertJsonStructure([
            'success',
            'message'
        ]);

        $response->assertStatus(200);
    }
}
