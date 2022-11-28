<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyChatList extends Model
{

    protected $fillable = [
        'title',
        'type',
        'fan_group_id',
        'qna_id',
        'status'
    ];


    protected $with = ['fangroup', 'qna'];


    public function fangroup()
    {
        return $this->belongsTo(FanGroup::class, 'fan_group_id');
    }

    public function qna()
    {
        return $this->belongsTo(QnaRegistration::class, 'qna_id');
    }

    use HasFactory;
}
