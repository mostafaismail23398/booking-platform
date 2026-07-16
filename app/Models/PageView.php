<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = ['path', 'ip_hash', 'user_agent', 'visited_at'];

    protected function casts(): array
    {
        return [
            'visited_at' => 'datetime',
        ];
    }
}
