<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'slug',
        'icon',
        'status'
    ];


    public function starCategory()
    {
        return $this->hasOne(StarCategory::class, 'category_id');
    }

    /**
     * one to many with liveChat
     */
    public function liveEvents()
    {
        return $this->hasMany(LiveChat::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    public function simplePosts()
    {
        return $this->hasMany(SimplePost::class, 'category_id');
    }
}
