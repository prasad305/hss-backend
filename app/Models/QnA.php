<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    protected $guarded = [];
        use HasFactory;
        
        public function star()
        {
            return $this->belongsTo(User::class, 'star_id');
        }
    
        public function admin()
        {
            return $this->belongsTo(User::class, 'created_by_id');
        }
}
