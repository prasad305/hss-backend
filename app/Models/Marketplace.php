<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'unit_price',
        'total_items',
        'keywords',
        'total_selling',
        'approved_date',
        'image',
        'status',
        'category_id',
        'subcategory_id',
        'sub_subcategory_id',
        'superstar_id',
    ];

    //Relation For API
    protected $with = ['superstar', 'starAdmin'];


    public function superstar()
    {
        return $this->belongsTo(User::class, 'superstar_id');
    }
    public function starAdmin()
    {
        return $this->belongsTo(User::class, 'superstar_admin_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
