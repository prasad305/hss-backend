<?php

namespace App\Models\Audition;


use App\Models\Audition\Audition;
use App\Models\AuditionRoundInstruction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundInfo extends Model
{
    use HasFactory;

    protected $with = ['videos', 'roundInstruction'];

    protected $fillable = [
        'id',
        'round_num',
        'audition_id',
        'audition_info_id',
        'has_jury_or_judge_mark',
        'jury_or_judge_mark',
        'has_user_vote_mark',
        'user_vote_mark',
        'mark_live_or_offline',
        'wildcard',
        'wildcard_status',
        'wildcard_round',
        'appeal',
        'video_feed',
        'video_duration',
        'video_slot_num',
        'round_start_date',
        'round_end_date',
        'instruction_prepare_start_date',
        'instruction_prepare_end_date',
        'video_upload_start_date',
        'video_upload_end_date',
        'jury_or_judge_mark_start_date',
        'jury_or_judge_mark_end_date',
        'result_publish_start_date',
        'result_publish_end_date',
        'appeal_start_date',
        'appeal_end_date',
        'appeal_result_publish_start_date',
        'appeal_result_publish_end_date',
        'status',
    ];

    public function videos(){
        return $this->hasMany(AuditionUploadVideo::class,'round_info_id');
    }

    public function roundInstruction(){
        return $this->hasOne(AuditionRoundInstruction::class,'round_info_id');
    }

}
