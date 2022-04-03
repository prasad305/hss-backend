<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function acquired_app()
    {

        return $this->hasMany(Acquired_app::class, 'bidding_id');
    }
    public function user()
    {

        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function auction()
    {

        return $this->hasMany(Auction::class, 'auction_id');
    }
}
