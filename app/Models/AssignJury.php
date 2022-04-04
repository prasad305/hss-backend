<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignJury extends Model
{
    use HasFactory;

    protected $fillable = [
        'audition_id',
        'participant_id',
        'jury_id',
        'status',
    ];
}
