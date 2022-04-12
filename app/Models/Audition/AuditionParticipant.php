<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'audition_id',
        'user_id',
        'jury_id',
        'marks_id',
        'winning_status',
        'video_url',
        'certificates',
        'accept_status',
        'comments',
        'filter_status',
        'status',
    ];
    protected $with = ['auditions'];
    public function filter()
    {
        return $this->hasMany(FilterVideo::class, 'participant_id', 'id');
    }

    public function auditions()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function judge()
    {
        return $this->hasMany(AssignJudge::class, 'judge_id', 'user_id');
    }

    public function mark()
    {
        return $this->hasMany(AuditionMark::class, 'participant_id');
    }
}
