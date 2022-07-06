<?php

namespace App\Models;

use App\Models\Audition\AuditionRoundInstructionSendInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundInstruction extends Model
{
    use HasFactory;
    protected $with = ['instructionSendInfos'];

    public function instructionSendInfos()
    {
        return $this->hasMany(AuditionRoundInstructionSendInfo::class,'audition_round_ins_id');
    }

    
}

