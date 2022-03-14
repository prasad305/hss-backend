<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = ['marketplace'];


    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class, 'marketplace_id');
    }
}
