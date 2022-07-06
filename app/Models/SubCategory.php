<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'slug',
        'icon',
        'status'
    ];

    public function starCategory()
    {
        return $this->hasOne(StarCategory::class, 'sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function simplePosts()
    {
        return $this->hasMany(SimplePost::class, 'category_id');
    }
    public function subSimplePosts()
    {
        return $this->hasMany(SimplePost::class, 'subcategory_id');
    }
}
