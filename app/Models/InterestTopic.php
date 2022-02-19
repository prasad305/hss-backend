<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'status',
    ];

    public function userInterests()
    {
        return $this->hasMany(UserInterest::class, 'interest_topic_id');
    }
}
