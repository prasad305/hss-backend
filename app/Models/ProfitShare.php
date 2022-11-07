<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitShare extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function withdrawHistory()
    {
        return $this->hasMany(ProfitWalletWithdrawHistory::class, 'profit_share_id');
    }
}
