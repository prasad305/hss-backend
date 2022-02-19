<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'status',
        'price',
    ];

    public function packageInfos()
    {
        return $this->hasMany(PackageInfo::class, 'package_id');
    }

    public function packageBuys()
    {
        return $this->hasMany(PackageBuy::class, 'package_id');
    }

}
