<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoVideo extends Model
{
    protected $fillable = [
        'admin_id',
        'video_url',
        'star_id',
        'title'
    ];
    use HasFactory;
}
