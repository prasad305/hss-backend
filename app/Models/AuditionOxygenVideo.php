<?php

namespace App\Models;

use App\Models\Audition\AuditionRoundInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionOxygenVideo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['user'];

    public function auditionRoundInfo()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'round_info_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
