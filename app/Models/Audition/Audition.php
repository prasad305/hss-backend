<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function auditionRules(){
        return $this->belongsTo(AuditionRules::class);
    }
    public function auditionRoundRules(){
        return $this->belongsTo(AuditionRoundRule::class);
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator_id');
    }
}
    
