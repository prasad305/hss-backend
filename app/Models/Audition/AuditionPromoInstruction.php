<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionPromoInstruction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with =['promoInstructionSendInfos'];

    public function promoInstructionSendInfos()
    {
        return $this->hasMany(AuditionPromoInstructionSendInfo::class, 'audition_promo_ins_id');
    }
}
