<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRoundMarkTracking extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['user'];
    public function roundInfo()
    {
        return $this->belongsTo(AuditionRoundInfo::class, 'round_info_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
