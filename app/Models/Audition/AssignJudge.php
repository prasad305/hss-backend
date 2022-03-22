<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignJudge extends Model
{
    use HasFactory;
    protected $fillable = [
        'audition_id',
        'judge_id',
        'approved_by_judge',
        'status'
    ];

    public function auditions(){
        return $this->belongsTo(Audition::class);
    }
}
