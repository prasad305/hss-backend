<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'marketplace_id'
    ];

    protected $with = ['souvenir', 'user', 'state', 'country', 'city', 'star','marketplace'];

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
        return $this->belongsTo(User::class, 'star_id');
    }
    public function souvenir()
    {
        return $this->belongsTo(SouvenirCreate::class, 'souvenir_id');
    }
    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }
}
