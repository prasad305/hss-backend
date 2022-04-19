<?php

namespace App\Models\Audition;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionRules extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }
}