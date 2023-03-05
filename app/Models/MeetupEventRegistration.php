<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetupEventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'meetup_event_id',
        'user_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'amount',
        'card_holder_name',
        'account_no',
    ];

    //Relation For API
    protected $with = ['user', 'meetupEvent']; // If we remove this, it will generate error in user activities 

    public function meetupEvent()
    {
        return $this->belongsTo(MeetupEvent::class, 'meetup_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
