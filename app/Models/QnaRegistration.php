<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnaRegistration extends Model
{
    use HasFactory;
    protected $with = ['user', 'qna'];

    public function qna()
    {
        return $this->belongsTo(QnA::class, 'qna_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
