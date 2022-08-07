<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'audition_event_id',
        'user_id',
        'parent_comment_id',
        'comment',
        'react_no',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parentComment()
    {
        return $this->belongsTo(AuditionComment::class, 'parent_comment_id');
    }

    public function childComments()
    {
        return $this->hasMany(AuditionComment::class, 'parent_comment_id');
    }

}
