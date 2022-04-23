<?php

namespace App\Models;

use App\Models\Audition\Audition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'event_id',
        'round_id',
        'event_type',
        'payment_type',
        'card_holder_name',
        'card_number',
        'date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function event()
    {
        if($this->event_type == 'audition'){
            return $this->belongsTo(Audition::class, 'event_id');
        }
    }

    // public function round()
    // {
    //     return $this->belongsTo(User::class, 'round_id');
    // }
}
