<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundMarkTracking extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function roundInfo()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'round_info_id');
    }
}
