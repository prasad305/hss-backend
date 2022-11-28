<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSessionCertificate extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['learningSession','user'];
    public function learningSession()
    {
        return $this->belongsTo(LearningSession::class, 'event_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
