<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'user_id',
        'chat_id',
        'topic',
        'level',
        'plan',
        'completed_days',
    ];

    protected $casts = [
        'plan' => 'array',
        'completed_days' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}