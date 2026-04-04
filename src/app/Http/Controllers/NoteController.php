<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Services\NoteService;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function __construct(private NoteService $noteService)
    {}

    public function importantNotes()
    {
        $notes = $this->noteService->importantNotes();

        return response()->json([
            'success' => true,
            'message' => 'Важные заметки с именами клиентов',
            'count' => $notes->count(),
            'items' => NoteResource::collection($notes)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $note = $this->noteService->getById($id);

        if ($note == null) {
            return response()->json([
                'success' => false,
                'message' =>  'Заметка не найдена'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Получена 1 заметка',
            'data' => NoteResource::make($note)
        ]);
    }

    public function store($clientId, NoteRequest $request): JsonResponse
    {
        $note = $this->noteService->store($clientId, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Вы создали заметку для пользователя ' . $note->client->name,
            'data' => NoteResource::make($note)
        ], 201);
    }

    public function update(int $id, NoteRequest $request): JsonResponse
    {
        $updatedNote = $this->noteService->update($id, $request->validated());

        if ($updatedNote == null) {
            return response()->json([
                'success' => false,
                'message' =>  'Заметка не найдена'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Заметка для клиента ' . $updatedNote->client->name . ' была обновлена',
            'data' => NoteResource::make($updatedNote)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deletedNote = $this->noteService->getById($id);
        $check = $this->noteService->destroy($id);

        if ($check == null) {
            return response()->json([
                'success' => false,
                'message' =>  'Заметка не найдена'
            ], 404);
        } else {
            $name = $deletedNote->client->name ?? '';
            if ($check) {
                return response()->json([
                    'success' => true,
                    'message' => 'Вы успешно удалили заметку о клиенте ' . $name
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Не удалось удалить заметку о клиенте ' . $name
            ], 500);
        }
    }

    public function restore(int $id): JsonResponse
    {
        $restoredNote = $this->noteService->restore($id);

        if ($restoredNote == null) {
            return response()->json([
                'success' => false,
                'message' => 'Заметка не найдена'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Заметка $restoredNote->id восстановлена"
        ]);
    }
}
