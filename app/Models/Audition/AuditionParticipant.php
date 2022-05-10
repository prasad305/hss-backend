<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionParticipant extends Model
{
    use HasFactory;
    protected $guarded = [];

    // protected $with = ['audition'];

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }

    public function participant(){
        return $this->belongsTo(User::class,'user_id');
    }
}
