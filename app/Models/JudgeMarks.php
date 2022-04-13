<?php

namespace App\Models;

use App\Models\Audition\AuditionParticipant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgeMarks extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function auditionsParticipant()
    {
        return $this->belongsTo(AuditionParticipant::class, 'video_id', 'id');
    }
}
