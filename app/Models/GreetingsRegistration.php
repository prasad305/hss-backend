<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GreetingsRegistration extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['user'];
    // protected $with = ['user', 'greeting'];

    //
    public function greeting()
    {
        return $this->belongsTo(Greeting::class, 'greeting_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
