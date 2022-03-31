<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplePost extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relation For API
    protected $with = ['star','admin'];


    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
