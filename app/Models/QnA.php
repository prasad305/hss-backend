<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    protected $guarded = [];
        use HasFactory;
        
        protected $with = ['star'];
        public function star()
        {
            return $this->belongsTo(User::class, 'star_id');
        }
    
        public function admin()
        {
            return $this->belongsTo(User::class, 'created_by_id');
        }
    
        // public function registeredLiveChats()
        // {
        //     return $this->hasMany(LiveChatRegistration::class, 'live_chat_id');
        // }
    
        public function Category()
        {
            return $this->hasOne(Category::class, 'id');
        }
}
