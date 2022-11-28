<?php

namespace App\Models\Audition;

use App\Models\Category;
use App\Models\JuryGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionAssignJury extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_id',
        'jury_id',
        'is_primary',
        'group_id',
        'category_id',
        'approved_by_jury',
        'status',
    ];

    protected $with = ['user'];

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }
    public function juryGroup()
    {
        return $this->belongsTo(JuryGroup::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
