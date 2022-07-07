<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionUploadVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_id',
        'user_id',
        'round_info_id',
        'jury_or_judge_id',
        'judge_id',
        'video',
        'approval_status',
        'comments',
        'status',
    ];

    protected $with = ['user'];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function round()
    // {
    //     return $this->belongsTo(User::class, 'round_id');
    // }
    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_or_judge_id');
    }
    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
