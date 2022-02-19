<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostVideo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'post_id',
        'video',
        'status',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
