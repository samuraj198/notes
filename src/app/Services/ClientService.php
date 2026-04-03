<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService
{
    public function getAll(): LengthAwarePaginator
    {
        return Client::orderBy('created_at', 'desc')->paginate(10);
    }

    public function getById(int $id): ?Client
    {
        return Client::with('notes')->find($id);
    }

    public function store(array $data): Client
    {
        return Client::create($data);
    }

    public function update(int $id, array $data): ?Client
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
