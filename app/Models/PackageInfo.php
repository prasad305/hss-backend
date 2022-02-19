<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'package_id',
        'info',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
