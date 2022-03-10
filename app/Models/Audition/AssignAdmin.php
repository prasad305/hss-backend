<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_type',
        'category',
        'assign_person',
        'status'
    ];
}
