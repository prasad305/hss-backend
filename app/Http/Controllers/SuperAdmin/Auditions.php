<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Auditions extends Controller
{
    use HasFactory;
    protected $fillable = [
        'title',
        'category_id',
        'audition_round_rules_id',
        'active_round_info_id',
        'creater_id',
        'audition_admin_id',
        'manager_admin_id',
        'slug',
        'instruction',
        'description',
        'banner',
        'video',
        'pdf',
        'round_status',
        'template_id',
        'user_reg_start_date',
        'user_reg_end_date',
        'start_date',
        'end_date',
        'status',
        'fees',
        'id'
    ];
    //
    public function marketplace_order()
    {
        return $this->hasMany(Activity::class, 'id');
    }
}
