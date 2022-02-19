<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarFollowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'star_id',
        'user_id',
    ];

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
