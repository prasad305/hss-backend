<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FanGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'description',
        'start_date',
        'end_date',
        'star_one',
        'star_two',
        'min_member',
        'max_member',
    ];
}
