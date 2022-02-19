<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetupEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'star_id',
        'meetup_type',
        'title',
        'event_link',
        'start_time',
        'end_time',
        'description',
        'venue',
        'total_seat',
        'banner',
        'participant_number',
        'video',
        'date',
        'time',
        'fee',
        'star_approval',
        'manager_approval',
        'status',
        'total_amount',
    ];

    //Relation For API
    protected $with = ['star','admin'];

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function registeredMeetupEvents()
    {
        return $this->hasMany(MeetupEventRegistration::class, 'meetup_event_id');
    }

}
