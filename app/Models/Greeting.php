<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'category_id',
        'star_id',
        'admin_id',
        'title',
        'description',
        'date',
        'participant_number',
        'registration_start_date',
        'registration_end_date',
        'banner',
        'video',
        'cost',
        'publish_status',
        'star_approve_status',
        'status',
    ];
}
