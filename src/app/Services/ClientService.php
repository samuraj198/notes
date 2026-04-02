<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{
    public function getAll(): Collection
    {
        return Client::sortBy('created_at', 'desc')->paginate(10);
    }

    public function getById(int $id): ?Client
    {
        $client = Client::find($id);

        if ($client == null) {
            return null;
        }

        return $client;
    }

    public function store(array $data): Client
    {
        return Client::create($data);
    }

    public function update(array $data, int $id): ?Client
    {
        $client = $this->getById($id);

        if ($client == null) {
            return null;
        }

        $client->update($data);

        return $client;
    }

    public function destroy(int $id): ?bool
    {
        $client = $this->getById($id);

        if ($client == null) {
            return null;
        }

        return $client->delete();
    }
}
