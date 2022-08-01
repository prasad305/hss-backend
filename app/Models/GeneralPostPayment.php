<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralPostPayment extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $with = ['user'];
    public function simpleposts()
    {
        return $this->belongsTo(SimplePost::class, 'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
