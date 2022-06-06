<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoVideo extends Model
{
    protected $fillable = [
        'admin_id',
        'video_url',
        'star_id',
        'category_id',
        'sub_category_id',
        'star_id',
        'star_approval',
        'title'
    ];
    use HasFactory;

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
