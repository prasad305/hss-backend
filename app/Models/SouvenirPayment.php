<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirPayment extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'id',
    //     'souvenir_order_id',
    //     'payment_date',
    //     'payment_method',
    //     'payment_status',
    //     'card_holder_name',
    //     'amount',
    //     'transaction_id',
    //     'status',
    //     'ccv',
    // ];

    public function souvenirOrder()
    {
        return $this->belongsTo(SouvenirOrder::class, 'souvenir_order_id');
    }
}
