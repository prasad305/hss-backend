<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSessionEvaluation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['assignment'];

    public function assignment()
    {
        return $this->hasMany(LearningSessionAssignment::class, 'evaluation_id');
    }
}
