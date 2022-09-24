<?php

namespace App\Models\Audition;

use App\Models\User;
use App\Models\Audition\AuditionUploadVideo;
use App\Models\LoveReact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['videos'];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }
    public function videos()
    {
        return $this->hasMany(AuditionUploadVideo::class, 'user_id', 'user_id');
    }

    public function participant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function totalLoveReact()
    {
        return $this->hasMany(LoveReact::class, 'participant_id', 'user_id')->selectRaw('participant_id, sum(react_num) as react_num')->groupBy('participant_id');
    }
}
