<?php

namespace App\Models;

use App\Models\Audition\AuditionRoundInstructionSendInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundInstruction extends Model
{
    use HasFactory;

    protected $with = ['instructionSendInfos'];

    protected $fillable = [
        'id',
        'audition_id',
        'round_info_id',
        'instruction',
        'description',
        'video',
        'image',
        'document',
        'submission_end_date',
        'send_to_judge',
        'send_to_manager',
        'status',
    ];

    public function instructionSendInfos()
    {
        return $this->hasMany(AuditionRoundInstructionSendInfo::class,'audition_round_ins_id');
    }


}

