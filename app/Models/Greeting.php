<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_by_id',
        'category_id',
        'star_id',
        'admin_id',
        'title',
        'description',
        'date',
        'participant_number',
        'registration_start_date',
        'registration_end_date',
        'banner',
        'video',
        'cost',
        'publish_status',
        'star_approve_status',
        'status',
    ];

    protected $with = ['star'];

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function registeredGreeting()
    {
        return $this->hasMany(GreetingsRegistration::class, 'greeting_id');
    }
}
