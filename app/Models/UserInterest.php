<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'interest_topic_id',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }

    public function interestTopic()
    {
        return $this->belongsTo(InterestTopic::class, 'interest_topic_id');
    }


}
