<?php

namespace App\Models;

use App\Models\Audition\Audition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'slug',
        'icon',
        'status'
    ];


    public function starCategory()
    {
        return $this->hasOne(StarCategory::class, 'category_id');
    }

    /**
     * one to many with liveChat
     */
    public function liveEvents()
    {
        return $this->hasMany(LiveChat::class, 'category_id');
    }
    public function qna()
    {
        return $this->hasMany(QnA::class, 'category_id');
    }
    public function meetup()
    {
        return $this->hasMany(MeetupEvent::class, 'category_id');
    }
    public function learningSession()
    {
        return $this->hasMany(LearningSession::class, 'category_id');
    }
    public function greeting()
    {
        return $this->hasMany(Greeting::class, 'category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    public function simplePosts()
    {
        return $this->hasMany(SimplePost::class, 'category_id');
    }
    public function fanGroup()
    {
        return $this->hasMany(FanGroup::class, 'category_id');
    }
    public function marketplace()
    {
        return $this->hasMany(Marketplace::class, 'category_id');
    }
    public function auction()
    {
        return $this->hasMany(Auction::class, 'category_id');
    }
    public function souvenir()
    {
        return $this->hasMany(SouvenirCreate::class, 'category_id');
    }
    public function audition()
    {
        return $this->hasMany(Audition::class, 'category_id');
    }
}
