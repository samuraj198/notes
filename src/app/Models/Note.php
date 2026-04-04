<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'client_id',
        'content',
        'is_important',
    ];

    protected $casts = [
        'is_important' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
