<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'client_name' => $this->client->name ?? null,
            'id' => $this->id,
            'content' => $this->content,
            'is_important' => $this->is_important
        ];
    }
}
