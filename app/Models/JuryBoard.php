<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryBoard extends Model
{
    use HasFactory;


    protected $fillable = [
        'jury_id',
        'admin_id',
        'category_id',
        'sub_category_id',
        'terms_and_condition',
        'description',
        'qr_code',
        'agreement',
        'status',
    ];

    protected $with = ['juryBoard'];

    public function juryBoard()
    {
        return $this->belongsto(User::class,'jury_id','id');
    }
}
