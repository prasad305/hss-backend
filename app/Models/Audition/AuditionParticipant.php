<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'audition_id',
        'user_id',
        'marks_id',
        'winning_status',
        'video_url',
        'certificates',
        'accept_status',
        'comments',
        'filter_status',
        'status',
    ];

    public function filter()
    {
        return $this->hasMany(FilterVideo::class, 'participant_id', 'id');
    }
    public function auditions()
    {

        return $this->hasMany(Audition::class, 'id', 'audition_id');
    }
    public function judge()
    {

        return $this->hasMany(AssignJudge::class, 'judge_id', 'user_id');
    }
}
