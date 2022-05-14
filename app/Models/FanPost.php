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
        'category_id',
    ];

    protected $with = ['user', 'star'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
