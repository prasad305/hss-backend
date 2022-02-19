<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souvenir extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'star_id',
        'title',
        'brand',
        'details',
        'price',
        'quantity',
        'status',
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
