<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FanGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'description',
        'start_date',
        'end_date',
        'star_one',
        'star_two',
        'min_member',
        'max_member',
        'banner',
        'category_id',
    ];
    //Relation For API
    protected $with = ['another_admin', 'another_superstar', 'my_superstar', 'my_admin'];

    public function my_admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function my_superstar()
    {
        return $this->belongsTo(User::class, 'my_star');
    }
    public function another_superstar()
    {
        return $this->belongsTo(User::class, 'another_star');
    }
    public function another_admin()
    {
        return $this->belongsTo(User::class, 'another_star_admin_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function star()
    {
        return $this->belongsTo(User::class, 'my_star');
    }
}
