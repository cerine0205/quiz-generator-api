<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender',
        'type',
        'content'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    protected $casts = [
        'content' => 'array'
    ];
}
