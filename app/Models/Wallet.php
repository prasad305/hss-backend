<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'club_point',
        'audition_cost',
        'amount',
        'status',
    ];

    public function star()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
