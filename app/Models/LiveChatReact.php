<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChatReact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'live_chat_id',
        'user_id',
        'react',
    ];

    public function liveChat()
    {
        return $this->belongsTo(LiveChat::class, 'live_chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
