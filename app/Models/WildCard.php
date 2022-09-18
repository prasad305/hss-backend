<?php

namespace App\Models;

use App\Models\Audition\AuditionRoundInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WildCard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function auditionRoundInfoStart()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'start_round_info_id');
    }
    public function auditionRoundInfoEnd()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'end_round_info_id');
    }
}
