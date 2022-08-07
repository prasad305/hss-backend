<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionJudgePanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_event_id',
        'star_id',
        'status',
    ];

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

}
