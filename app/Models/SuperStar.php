<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperStar extends Model
{
    use HasFactory;

    protected $fillable = [
        'star_id',
        'admin_id',
        'category_id',
        'sub_category_id',
        'terms_and_condition',
        'description',
        'qr_code',
        'agreement',
        'signature',
        'status',
    ];

    protected $with = ['superStar'];

    public function superStar()
    {
        return $this->belongsto(User::class,'star_id','id');
    }
    public function auction(){
        return $this->hasMany(Auction::class,'star_id');
    }
}
