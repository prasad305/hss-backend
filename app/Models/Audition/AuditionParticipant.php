<?php

namespace App\Models\Audition;

use App\Models\User;
use App\Models\Audition\AuditionUploadVideo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['videos'];

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }
    public function videos(){
        return $this->hasMany(AuditionUploadVideo::class,'user_id', 'user_id');
    }

    public function participant(){
        return $this->belongsTo(User::class,'user_id');
    }



}
