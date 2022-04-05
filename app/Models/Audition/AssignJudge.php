<?php

namespace App\Models\Audition;

use App\Models\User;
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

    protected $with = ['user'];

    public function auditions()
    {
        return $this->belongsTo(Audition::class);
    }
    public function audition()
    {
        return $this->hasMany(Audition::class, 'id', 'audition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'judge_id', 'id');
    }
}
