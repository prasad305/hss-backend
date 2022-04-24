<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function auditionRules(){
        return $this->belongsTo(AuditionRules::class,'audition_rules_id');
    }

    public function auditionRoundRules(){
        return $this->belongsTo(AuditionRoundRule::class,'audition_round_rules_id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator_id');
    }
    public function auditionAdmin(){
        return $this->belongsTo(User::class,'audition_admin_id');
    }
    public function assignJudge(){
        return $this->hasMany(AuditionAssignJudge::class);
    }
    public function participants(){
        return $this->hasMany(AuditionParticipant::class);
    }
}
    
