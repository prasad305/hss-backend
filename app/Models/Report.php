<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reported_user_id',
        'against_user_id',
        'issue',
        'document',
        'date',
        'status',
    ];

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reportAgainstUser()
    {
        return $this->belongsTo(User::class, 'against_user_id');
    }
}
