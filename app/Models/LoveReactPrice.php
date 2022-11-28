<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoveReactPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'love_points',
        'price',
    ];

}
