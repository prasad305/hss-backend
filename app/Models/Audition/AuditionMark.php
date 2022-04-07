<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionMark extends Model
{
    protected $guarded = [];
    use HasFactory;
    

    public function auditionsParticipant()
    {

        return $this->belongsTo(AuditionParticipant::class, 'participant_id');
    }
}
