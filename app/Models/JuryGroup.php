<?php

namespace App\Models;

use App\Models\Audition\AuditionAssignJury;
use App\Models\JuryBoard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuryGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['juries','category'];

    public function juries()
    {
        return $this->hasMany(AuditionAssignJury::class, 'group_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function board()
    {
        return $this->hasMany(JuryBoard::class, 'group_id');
    }
}
