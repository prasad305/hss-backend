<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionReact extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_event_id',
        'user_id',
        'react',
    ];

    public function auditionEvents()
    {
        return $this->belongsTo(AuditionEvent::class, 'audition_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
