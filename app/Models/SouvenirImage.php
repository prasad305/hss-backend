<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'souvenir_id',
        'image',
    ];

    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id');
    }
}
