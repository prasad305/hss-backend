<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionUploadVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_id',
        'user_id',
        'round_id',
        'jury_id',
        'judge_id',
        'video',
        'approval_status',
        'comments',
        'status',
    ];

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
        return $this->belongsTo(User::class, 'jury_id');
    }
    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
