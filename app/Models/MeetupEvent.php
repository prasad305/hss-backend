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
        'admin_id',
        'category_id',
        'meetup_type',
        'title',
        'event_link',
        'start_time',
        'end_time',
        'description',
        'instruction',
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
        'reg_start_date',
        'reg_end_date',
        'total_amount',
        'category_id'
    ];

    //Relation For API
    // protected $with = ['star', 'admin'];
    protected $with = ['star'];

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function registeredMeetupEvents()
    {
        return $this->hasMany(MeetupEventRegistration::class, 'meetup_event_id');
    }
    public function totalRegisteredMeetupSlot()
    {
        return $this->hasMany(MeetupEventRegistration::class, 'meetup_event_id')->where('payment_status', 1);
    }
}
