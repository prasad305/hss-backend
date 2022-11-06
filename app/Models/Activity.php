<?php

namespace App\Models;
use App\Models\Audition\Audition;
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
        'marketplace_id',
        'souvenir_id',

    ];

    //, 'marketPlaceOrder', 'marketPlace'
    protected $with = ['user', 'meetup', 'meetupRegistration', 'souvenirApply', 'livechat', 'livechatRegistration', 'learningSession', 'learningSessionRegistration', 'greetingRegistration', 'greeting', 'qna', 'qnaRegistration', 'auction', 'audition', 'marketPlaceOrder', 'marketPlace'];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meetup()
    {
        return $this->belongsTo(MeetupEvent::class, 'event_id');
    }
    public function meetupRegistration()
    {
        return $this->belongsTo(MeetupEventRegistration::class, 'event_registration_id');
    }

    public function livechat()
    {
        return $this->belongsTo(LiveChat::class, 'event_id');
    }
    public function livechatRegistration()
    {
        return $this->belongsTo(LiveChatRegistration::class, 'event_registration_id');
    }
    public function qna()
    {
        return $this->belongsTo(QnA::class, 'event_id');
    }
    public function qnaRegistration()
    {
        return $this->belongsTo(QnaRegistration::class, 'event_registration_id');
    }

    public function learningSession()
    {
        return $this->belongsTo(LearningSession::class, 'event_id');
    }
    public function learningSessionRegistration()
    {
        return $this->belongsTo(LearningSessionRegistration::class, 'event_registration_id');
    }
    public function greetingRegistration()
    {
        return $this->belongsTo(GreetingsRegistration::class, 'event_registration_id');
    }
    public function greeting()
    {
        return $this->belongsTo(Greeting::class, 'event_id');
    }
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'event_id');
    }
    public function marketPlace()
    {
        return $this->belongsTo(marketPlace::class, 'event_id');
    }
    public function marketPlaceOrder()
    {
        return $this->belongsTo(MarketPlaceOrder::class, 'event_registration_id');
    }
    public function souvenirApply()
    {
        return $this->belongsTo(SouvenirApply::class, 'event_registration_id');
    }

    public function audition(){
        return $this->belongsTo(Audition::class, 'event_id');

    }
}
