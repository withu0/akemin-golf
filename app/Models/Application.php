<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'handled' => 'boolean',
        ];
    }
}
