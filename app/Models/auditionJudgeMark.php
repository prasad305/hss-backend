<?php

namespace App\Models;

use App\Models\Audition\AuditionUploadVideo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auditionJudgeMark extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function judge_videos()
    {
        return $this->belongsTo(AuditionUploadVideo::class, 'audition_uploads_video_id');
    }
}
