<?php

namespace App\Models\Audition;

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

    protected $with = ['user'];

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

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
