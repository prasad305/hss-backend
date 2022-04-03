<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'audition_id',
        'user_id',
        'card_holder_name',
        'card_number'

    ];
}
