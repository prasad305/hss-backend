<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChatRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'live_chat_id',
        'user_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'amount',
        'card_holder_name',
        'account_no',
        'live_chat_start_time',
        'live_chat_end_time',
        'live_chat_date',
        'video',
        'comment_count',
        'publish_status',
    ];

    protected $with = ['user', 'liveChat'];

    public function liveChat()
    {
        return $this->belongsTo(LiveChat::class, 'live_chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function liveChatRoom()
    {
        return $this->belongsTo(LiveChatRoom::class, 'live_chat_id', 'live_chat_id');
    }
}
