<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
