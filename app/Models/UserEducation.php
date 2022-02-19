<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'subject',
        'institute',
        'passing_year',
        'grade',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
