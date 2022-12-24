<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['notificationText'];

    public function notificationText()
    {
        return $this->belongsTo(NotificationText::class, 'notification_id');
    }
}
