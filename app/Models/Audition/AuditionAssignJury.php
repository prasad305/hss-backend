<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function audition()
    {
        return $this->belongsTo(Audition::class, 'audition_id');
    }

    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }
}
