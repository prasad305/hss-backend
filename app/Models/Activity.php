<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'event_id',
        'user_id',
    ];

    protected $with = ['user', 'meetup', 'livechat', 'learningSession'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meetup()
    {
        return $this->belongsTo(MeetupEvent::class, 'event_id');
    }

    public function livechat()
    {
        return $this->belongsTo(LiveChat::class, 'event_id');
    }

    public function learningSession()
    {
        return $this->belongsTo(LearningSession::class, 'event_id');
    }
}
