<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'category_id',
        'star_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'banner',
        'video',
        'total_seat',
        'total_amount',
        'fee',
        'participant_number',
        'registration_start_date',
        'registration_end_date',
        'max_time_per_person',
        'publish_status',
        'status',
    ];
    protected $with = ['star'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function registeredLiveChats()
    {
        return $this->hasMany(LiveChatRegistration::class, 'live_chat_id');
    }


    public function reacts()
    {
        return $this->hasMany(LiveChat::class, 'live_chat_id');
    }

    public function comments()
    {
        return $this->hasMany(LiveChatComment::class, 'live_chat_id');
    }


    public function Category()
    {
        return $this->hasOne(Category::class, 'id');
    }
}
