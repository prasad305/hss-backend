<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionJudgeInstruction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_id',
        'star_id',
        'round_id',
        'title',
        'banner',
        'video',
        'status',
        'description',
        'time_boundary',
        'date',
    ];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
}
