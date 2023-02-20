<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'invoice_no',
        'order_no',
        'marketplace_id',
        'superstar_id',
        'superstar_admin_id',
        'country_id',
        'state_id',
        'city_id',
        'delivery_charge_id',
        'area',
        'phone',
        'items',
        'unit_price',
        'tax',
        'total_price',
        'holder_name',
        'card_no',
        'card_holder_name',
        'account_no',
        'payment_date',
        'payment_status',
        'expire_date',
        'cvc',
        'status',
        'delivery_at',
    ];

    // protected $with = ['marketplace', 'user', 'state', 'country', 'city', 'star'];
    protected $with = ['marketplace'];


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
    public function deliverycharge()
    {
        return $this->belongsTo(DeliveryCharge::class, 'delivery_charge_id');
    }
}