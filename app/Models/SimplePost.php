<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimplePost extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relation For API
    // protected $with = ['star', 'admin', 'generalPostPayment'];


    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
    public function generalPostPayment()
    {
        return $this->hasMany(GeneralPostPayment::class, 'post_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function starAdmin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function starPosts()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
}
