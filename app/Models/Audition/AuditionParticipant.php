<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'audtion_id',
        'user_id',
        'marks_id',
        'winning_status',
        'video_url',
        'certificates',
        'accept_status',
        'comments',
        'status',
    ];
}
