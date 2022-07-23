<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fan_Group_Join extends Model
{
    use HasFactory;

    //Relation For API
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function fanGroup()
    {
        return $this->belongsTo(FanGroup::class, 'fan_group_id');
    }
}
