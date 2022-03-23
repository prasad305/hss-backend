<?php

namespace App\Models\Audition;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audition extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'creater_id',
        'admin_id',
        'title',
        'slug',
        'description',
        'banner',
        'video',
        'start_time',
        'end_time',
        'round_stattus',
        'template_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function assignAdmin(){
        return $this->hasOne(AssignAdmin::class, 'job_id','id');
    }
    public function judge(){
        return $this->hasOne(AssignJudge::class, 'audition_id','id');
    }
}
