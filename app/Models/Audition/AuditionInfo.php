<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionInfo extends Model
{
    use HasFactory;
    protected $with = ['auditionRounds'];
    

    public function auditionRounds()
    {
        return $this->hasMany(AuditionRoundInfo::class,'audition_info_id');
    }
}
