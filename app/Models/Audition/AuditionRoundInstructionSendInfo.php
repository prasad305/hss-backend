<?php

namespace App\Models\Audition;


use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundInstructionSendInfo extends Model
{
    use HasFactory;
    protected $with = ['star'];

    public function star()
    {
        return $this->belongsTo(User::class,'judge_id');
    }
}

