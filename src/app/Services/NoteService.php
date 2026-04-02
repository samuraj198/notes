<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    public function getById(int $id): ?Note
    {
        return Note::find($id);
    }

    public function store(int $clientId, array $data): Note
    {
        $data['client_id'] = $clientId;
        $note = Note::create($data);

        return $note;
    }

    public function update(int $id, array $data): ?Note
    {
        $note = $this->getById($id);

        if ($note == null) {
            return null;
        }

        $note->update($data);

        return $note;
    }

    public function destroy(int $id): ?bool
    {
        $note = $this->getById($id);

        if ($note == null) {
            return null;
        }

        return $note->delete();
    }
}
