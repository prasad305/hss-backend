<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FanPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'description',
        'video',
        'star_id',
        'star_name',
        'like_count',
        'status',
        'fan_group_id',
        'user_id',
    ];
}
