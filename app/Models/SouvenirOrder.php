<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'souvenir_id',
        'order_date',
        'quantity',
        'delivery_status',
        'delivery_date',
        'amount',
        'price',
        'status',
    ];

    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id');
    }

    public function souvenirOrder()
    {
        return $this->hasOne(SouvenirPayment::class, 'souvenir_order_id');
    }
}
