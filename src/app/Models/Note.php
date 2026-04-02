<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'client_id',
        'content',
        'is_important',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
