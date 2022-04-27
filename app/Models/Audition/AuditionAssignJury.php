<?php

namespace App\Models\Audition;

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
        'approved_by_jury',
        'status',
    ];
    protected $with = ['user'];
    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }


}
