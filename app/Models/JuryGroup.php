<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function juries()
    // {
    //     return $this->hasMany(JuryBoard::class, 'group_id');
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
