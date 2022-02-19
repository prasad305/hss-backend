<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChatComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'live_chat_id',
        'user_id',
        'parent_comment_id',
        'comment',
        'react_no',
        'status',
    ];

    public function liveChat()
    {
        return $this->belongsTo(LiveChat::class, 'live_chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentComment()
    {
        return $this->belongsTo(LiveChatComment::class, 'parent_comment_id');
    }

    public function childComments()
    {
        return $this->hasMany(LiveChatComment::class, 'parent_comment_id');
    }
}
