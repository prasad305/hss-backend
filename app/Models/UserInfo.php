<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_fan_group_id',
        'nid',
        'passport',
        'gender',
        'country',
        'dob',
        // 'company',
        'salery_range',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
