<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'created_by_id',
        'description',
        'banner',
        'video',
        'cost',
        'type'
    ];
}
