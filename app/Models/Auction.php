<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function star()
    {
        return $this->belongsTo(User::class, 'star_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function bidding()
    {
        return $this->hasMany(Bidding::class, 'auction_id');
    }
}
