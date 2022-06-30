<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionAssignJudge extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['user','admin','judge_instruction'];

    public function user(){
        return $this->belongsTo(User::class,'judge_id');
    }

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'judge_admin_id');
    }

    public function judge_instruction(){
        return $this->belongsTo(AuditionJudgeInstruction::class,  'judge_id', 'judge_id');
    }
}
