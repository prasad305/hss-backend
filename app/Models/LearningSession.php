<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'star_id',
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
        'start_time',
        'end_time',
        'time',
        'fee',
        'status',
        'room_id',
        'total_amount',
    ];
    protected $with = ['star','learningSessionAssignment'];

    public function admin()
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

    public function registeredLearningSessions()
    {
        return $this->hasMany(LearningSessionRegistration::class, 'learning_session_id');
    }

    public function learningSessionAssignment()
    {
        return $this->hasMany(LearningSessionAssignment::class, 'event_id');
    }
}
