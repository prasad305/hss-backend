<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StarCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'star_id',
        'category_id',
        'sub_category_id',
    ];

    public function stars()
    {
        return $this->belongsToMany(User::class, 'star_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'sub_category_id');
    }

}
