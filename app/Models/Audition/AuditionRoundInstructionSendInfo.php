<?php

namespace App\Models\Audition;


use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundInstructionSendInfo extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['star'];

    public function star()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }
}
