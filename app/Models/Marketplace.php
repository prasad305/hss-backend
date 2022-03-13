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
        'image',
        'status',
    ];

    //Relation For API
    protected $with = ['superstar'];


    public function superstar()
    {
        return $this->belongsTo(User::class, 'superstar_id');
    }
}
