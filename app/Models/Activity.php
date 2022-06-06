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
        'event_registration_id',
        'user_id',
    ];

    protected $with = ['user', 'meetup', 'livechat', 'learningSession','greetingRegistration','greeting','qna'];


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
    public function qna()
    {
        return $this->belongsTo(QnA::class, 'event_id');
    }

    public function learningSession()
    {
        return $this->belongsTo(LearningSession::class, 'event_id');
    }
    public function greetingRegistration()
    {
        return $this->belongsTo(GreetingsRegistration::class, 'event_registration_id');
    }
    public function greeting()
    {
        return $this->belongsTo(Greeting::class, 'event_id');
    }
}
