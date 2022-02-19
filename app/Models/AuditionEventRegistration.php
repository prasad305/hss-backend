<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionEventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_event_id',
        'user_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'amount',
        'card_holder_name',
        'account_no',
        'image',
        'video',
        'comment_count',
    ];

    public function auditionEvent()
    {
        return $this->belongsTo(AuditionEvent::class, 'audition_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
