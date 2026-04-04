<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_all_clients()
    {
        Client::factory(5)->create();

        $response = $this->get('/api/clients');

        $response->assertJsonStructure([
            'success',
            'message',
            'count',
            'items' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone'
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_get_one_client()
    {
        $client = Client::factory()->create();

        $response = $this->get('/api/clients/' . $client->id);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'phone'
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_store_client()
    {
        $data = [
            'name' => 'Daniil',
            'email' => 'daniil@gmail.com',
            'phone' => '1234567890'
        ];

        $this->assertDatabaseMissing('clients', $data);

        $response = $this->post('/api/clients', $data);

        $this->assertDatabaseHas('clients', $data);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'phone'
            ]
        ]);

        $response->assertStatus(201);
    }

    public function test_update_client()
    {
        $client = Client::factory()->create();

        $this->assertDatabaseMissing('clients', ['name' => 'Daniil']);

        $data = [
            'name' => 'Daniil'
        ];

        $response = $this->put('/api/clients/' . $client->id, $data);

        $this->assertDatabaseHas('clients', $data);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'email',
                'phone'
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_client()
    {
        $client = Client::factory()->create();

        $this->assertDatabaseHas('clients', ['id' => $client->id]);

        $response = $this->delete('/api/clients/' . $client->id);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);

        $response->assertJsonStructure([
            'success',
            'message'
        ]);

        $response->assertStatus(200);
    }
}
