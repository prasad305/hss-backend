<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningSessionRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'learning_session_id',
        'user_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'amount',
        'card_holder_name',
        'account_no',
    ];

    public function learningSession()
    {
        return $this->belongsTo(LearningSession::class, 'learning_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
