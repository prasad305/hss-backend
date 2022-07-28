<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundAppealRegistration extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['audition','round'];

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }

    public function round(){
        return $this->belongsTo(AuditionRoundInfo::class, 'round_info_id');
    }
}
