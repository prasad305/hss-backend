<?php

namespace App\Models;

use App\Models\Audition\Audition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'event_id',
        'category_id',
        'user_id',
        'comment_number',
        'react_number',
        'share_number',
        'title',
        'details',
        'share_link',
        'react_provider',
        'status',
    ];

    protected $with = ['star', 'meetup', 'livechat', 'general', 'react', 'learningSession','audition'];

    public function star()
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

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'event_id');
    }

    public function general()
    {
        return $this->belongsTo(SimplePost::class, 'event_id');
    }

    public function react()
    {
        return $this->hasMany(React::class, 'post_id');
    }

    // public function liked()
    // {
    //     return $this->hasMany(React::class, 'post_id')->where('user_id',auth('sanctum')->user()->id)->first();
    // }

    public function postImages()
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }
}
