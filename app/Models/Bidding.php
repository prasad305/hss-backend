<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $with = ['user'];
    public function acquired_app()
    {

        return $this->hasMany(Acquired_app::class, 'bidding_id');
    }
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');
    }
    public function auction()
    {

        return $this->belongsTo(Auction::class, 'auction_id');
    }
}
