<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirCreate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instruction',
        'price',
        'banner',
    ];

    protected $with = ['star'];

    public function images()
    {
        return $this->hasMany(SouvenirImage::class, 'souvenir_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function souvenirOrders()
    {
        return $this->hasMany(SouvenirOrder::class, 'souvenir_id');
    }
    public function souvenirApply()
    {
        return $this->hasMany(SouvenirApply::class, 'souvenir_id');
    }
}
