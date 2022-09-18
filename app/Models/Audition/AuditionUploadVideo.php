<?php

namespace App\Models\Audition;

use App\Models\auditionJudgeMark;
use App\Models\LoveReact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionUploadVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_id',
        'user_id',
        'round_info_id',
        'jury_or_judge_id',
        'audition_admin_id',
        'group_a_per_jury_id',
        'group_a_ran_jury_id',
        'group_b_jury_id',
        'group_c_jury_id',
        'video',
        'approval_status',
        'audition_admin_comment',
        'group_a_jury_mark',
        'group_b_jury_mark',
        'group_c_jury_mark',
        'jury_or_judge_avg_mark',
        'user_vote_avg_mark',
        'comment'
    ];

    protected $with = ['user', 'totalReact'];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roundInfo()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'round_info_id');
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
    public function judge_video_mark()
    {
        return $this->hasMany(auditionJudgeMark::class, 'audition_uploads_video_id', 'id');
    }
    public function totalReact()
    {
        return $this->hasMany(LoveReact::class, 'video_id');
    }
}
