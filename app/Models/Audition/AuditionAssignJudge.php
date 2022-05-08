<?php

namespace App\Models\Audition;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionAssignJudge extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['user','admin'];

    public function user(){
        return $this->belongsTo(User::class,'judge_id');
    }

    public function audition(){
        return $this->belongsTo(Audition::class,'audition_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'judge_admin_id');
    }
}
