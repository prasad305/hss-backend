<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'slug',
        'icon',
        'status'
    ];

    public function starCategory()
    {
        return $this->hasOne(StarCategory::class, 'sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function simplePosts()
    {
        return $this->hasMany(SimplePost::class, 'category_id');
    }
    public function subSimplePosts()
    {
        return $this->hasMany(SimplePost::class, 'subcategory_id');
    }
    public function subLearningSession()
    {
        return $this->hasMany(LearningSession::class, 'sub_category_id');
    }
    public function subliveChat()
    {
        return $this->hasMany(LiveChat::class, 'sub_category_id');
    }
    public function subqna()
    {
        return $this->hasMany(QnA::class, 'sub_category_id');
    }
    public function submeetup()
    {
        return $this->hasMany(MeetupEvent::class, 'sub_category_id');
    }
    public function subfangroup()
    {
        return $this->hasMany(FanGroup::class, 'sub_category_id');
    }
    public function subgreeting()
    {
        return $this->hasMany(Greeting::class, 'sub_category_id');
    }
}
