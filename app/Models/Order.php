<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = ['marketplace', 'user', 'state', 'country', 'city', 'star'];


    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    
    public function star()
    {
        return $this->belongsTo(User::class, 'superstar_id');
    }
}
