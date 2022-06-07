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

    public function images()
    {
        return $this->hasMany(SouvenirImage::class, 'souvenir_id');
    }

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }

    public function souvenirOrders()
    {
        return $this->hasMany(SouvenirOrder::class, 'souvenir_id');
    }
}
