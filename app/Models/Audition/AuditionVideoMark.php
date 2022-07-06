<?php

namespace App\Models\Audition;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditionVideoMark extends Model
{
    use HasFactory;
    // protected $with = ['video'];
    // public function video(){
    //     return $this->belongsTo(AuditionUploadVideo::class,'video_id');
    // }
}
