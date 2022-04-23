<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionAssignJudge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function judge(){
        return $this->belongsTo(User::class,'judge_id');
    }
    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }
}
