<?php

namespace App\Models\Audition;
use App\Models\Audition\Audition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AuditionPromoInstructionSendInfo extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'id',
        'audition_promo_ins_id',
        'audition_id',
        'judge_id',
        'round_id',
        'instruction',
        'description',
        'video',
        'image',
        'document',
        'start_date',
        'end_date',
        'status',
    ];

    // protected $with = ['audition'];

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }

    // public function audition()
    // {
    //     return $this->belongsTo(Audition::class, 'audition_id');
    // }
    // public function judge()
    // {
    //     return $this->belongsTo(User::class, 'judge_id');
    // }



}
