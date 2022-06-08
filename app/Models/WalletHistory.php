<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;

    protected $with = ['package', 'user', 'walletpayment'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class, 'packages_id');
    }
    public function walletpayment()
    {
        return $this->belongsTo(WalletPayment::class, 'wallet_payment_id');
    }
}
