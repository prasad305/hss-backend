<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'admin_id',
        'event_type',
        'user_id',
        'from',
        'to',
        'date',
        'month',
        'status',
    ];

    protected $with = ['star', 'admin'];

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
