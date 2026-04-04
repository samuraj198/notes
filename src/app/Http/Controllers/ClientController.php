<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(private ClientService $clientService)
    {}

    public function index(): JsonResponse
    {
        $clients = $this->clientService->getAll();

        return response()->json([
            'success' => true,
            'message' => 'Список клиентов',
            'count' => $clients->count(),
            'items' => ClientResource::collection($clients)
        ]);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $client = $this->clientService->store($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Клиент успешно создан',
            'data' => ClientResource::make($client)
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $client = $this->clientService->getById($id);

        if ($client === null) {
            return response()->json([
                'success' => false,
                'message' => 'Клиент не найден'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Получен клиент',
            'data' => ClientResource::make($client)
        ]);
    }

    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        $updatedClient = $this->clientService->update($id, $request->validated());

        if ($updatedClient === null) {
            return response()->json([
                'success' => false,
                'message' => 'Клиент не найден'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Данные клиента успешно обновлены',
            'data' => ClientResource::make($updatedClient)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $check = $this->clientService->destroy($id);

        if ($check == null) {
            return response()->json([
                'success' => false,
                'message' => 'Клиент не найден'
            ], 404);
        } else {
            if ($check) {
                return response()->json([
                    'success' => true,
                    'message' => 'Клиент успешно удален'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Не удалось удалить клиента'
            ], 500);
        }
    }
}
