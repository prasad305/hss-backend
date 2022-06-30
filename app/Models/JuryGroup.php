<?php

namespace App\Models;

use App\Models\Audition\AuditionAssignJury;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['juries'];

    public function juries()
    {
        return $this->hasMany(AuditionAssignJury::class, 'group_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
