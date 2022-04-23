<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundRule extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function auditionRules(){
        return $this->belongsTo(AuditionRules::class,'audition_rules_id');
    }
    public function auditions(){
        return $this->hasMany(Audition::class);
    }
  
}
