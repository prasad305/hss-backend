<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionUserVoting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'video_id',
        'audition_id',
        'user_id',
        'round_id',
        'comments',
        'status',
    ];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function round()
    // {
    //     return $this->belongsTo(User::class, 'round_id');
    // }
    public function video()
    {
        return $this->belongsTo(User::class, 'video_id');
    }
}
