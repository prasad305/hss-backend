<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarTimeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'star_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
}
