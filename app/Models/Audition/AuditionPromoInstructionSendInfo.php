<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionPromoInstructionSendInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_promo_ins_id',
        'audition_id',
        'judge_id',
        'round_id',
        'instruction',
        'description',
        'video',
        'image',
        'document',
        'submission_end_date',
        'status',
    ];
}