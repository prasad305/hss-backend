<?php

namespace App\Models\Audition;

use App\Models\Category;
use App\Models\JuryGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audition extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['assignedJudges', 'info', 'category', 'participant', 'activeRoundInfo', 'auditionRules', 'assignedJuries', 'uploadedVideos', 'admin', 'auditionAdmin', 'auditionRound'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function info()
    {
        return $this->hasOne(AuditionInfo::class, 'audition_id');
    }

    public function promoInstruction()
    {
        return $this->hasOne(AuditionPromoInstruction::class, 'audition_id');
    }


    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function auditionRules()
    {
        return $this->belongsTo(AuditionRules::class, 'audition_rules_id');
    }

    public function auditionRoundRules()
    {
        return $this->belongsTo(AuditionRoundRule::class, 'audition_round_rules_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function auditionAdmin()
    {
        return $this->belongsTo(User::class, 'audition_admin_id');
    }
    public function assignedJudges()
    {
        return $this->hasMany(AuditionAssignJudge::class, 'audition_id', 'id');
    }
    public function assignedJuries()
    {
        return $this->hasMany(AuditionAssignJury::class, 'audition_id', 'id');
    }
    public function participant()
    {
        return $this->hasMany(AuditionParticipant::class, 'audition_id', 'id');
    }

    public function judge()
    {
        return $this->hasMany(AuditionAssignJudge::class, 'audition_id', 'id');
    }

    public function jury()
    {
        return $this->hasMany(AuditionAssignJury::class, 'audition_id', 'id');
    }
    public function admin()
    {
        return $this->hasMany(AuditionAssignJudge::class, 'audition_id', 'id');
    }
    public function judgeInstructions()
    {
        return $this->hasMany(AuditionJudgeInstruction::class, 'audition_id', 'id');
    }

    public function uploadedVideos()
    {
        return $this->hasMany(AuditionUploadVideo::class, 'audition_id', 'id');
    }

    public function auditionRound()
    {
        return $this->hasMany(AuditionRoundInfo::class, 'audition_id', 'id');
    }
    public function activeRoundInfo()
    {
        return $this->hasOne(AuditionRoundInfo::class, 'id', 'active_round_info_id');
    }
}
