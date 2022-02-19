<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'star_id',
        'meetup_type',
        'title',
        'registration_end_date',
        'registration_start_date',
        'description',
        'venue',
        'total_seat',
        'banner',
        'participant_number',
        'video',
        'date',
        'time',
        'fee',
        'status',
        'total_amount',
    ];

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function registeredAuditionEvents()
    {
        return $this->hasMany(AuditionEventRegistration::class, 'audition_event_id');
    }

    public function comments()
    {
        return $this->hasMany(AuditionComment::class, 'audition_event_id');
    }
}
