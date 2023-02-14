<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LearningSessionAssignment extends Model
{
    use HasFactory;

    // protected $with = ['user'];


    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }


}
