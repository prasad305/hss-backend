<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionJudgeMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'judge_id',
        'participant_id',
        'marks',
        'comments',
        'status',
    ];

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}
