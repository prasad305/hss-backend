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
    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
}
