<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'group_id',
        'terms_and_condition',
        'description',
        'qr_code',
        'agreement',
        'status',
    ];

    protected $with = ['juryBoard','group','assignjuries'];

    public function juryBoard()
    {
        return $this->belongsto(User::class,'star_id','id');
    }

    public function group()
    {
        return $this->belongsto(JuryGroup::class,'group_id','id');
    }
    public function assignjuries()
    {
        return $this->belongsTo(User::class,'star_id');
    }
}
