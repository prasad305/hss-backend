<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'subcategory',
        'star_id',
    ];
}
