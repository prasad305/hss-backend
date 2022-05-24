<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'terms_and_condition',
        'description',
        'qr_code',
        'agreement',
        'status',
    ];

    protected $with = ['juryBoard'];

    public function juryBoard()
    {
        return $this->belongsto(User::class,'star_id','id');
    }
}
