<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'audition_id',
        'admin_id',
        'participant_id',
        'comments',
        'accept_status',
        'status',
    ];

  

}
