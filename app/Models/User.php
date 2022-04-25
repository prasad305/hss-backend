<?php

namespace App\Models;

use App\Models\Audition\AssignAdmin;
use App\Models\Audition\Audition;
use App\Models\Audition\AuditionMark;
use App\Models\Category;
use App\Models\Audition\AuditionParticipant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'first_name',
        'last_name',
        'phone',
        'email',
        'otp',
        'otp_verified_at',
        'image',
        'cover_photo',
        'status',
        'email_send_status',
        'user_type',
        'password',
        'parent_user',
        'category_id'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    //Relation For API
    protected $with = ['userInfo'];



    public function parent()
    {
        return $this->hasOne(User::class, 'parent_user');
    }

    public function star()
    {
        return $this->hasOne(User::class, 'parent_user');
    }


    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function userInterests()
    {
        return $this->hasMany(UserInterest::class, 'user_id');
    }

    public function userEducations()
    {
        return $this->masMany(UserEducation::class, 'user_id');
    }

    public function reportsAgainstMe()
    {
        return $this->hasMany(User::class, 'against_user_id');
    }

    public function reports()
    {
        return $this->hasMany(User::class, 'reported_user_id');
    }

    public function souvenirs()
    {
        return $this->hasMany(Souvenir::class, 'star_id');
    }

    public function starCategory()
    {
        return $this->hasOne(StarCategory::class, 'user_id');
    }

    public function wallet()
    {
        return $this->hasOne(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function postReacts()
    {
        return $this->hasMany(PostReact::class, 'user_id');
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function package()
    {
        return $this->hasOne(Package::class, 'user_id');
    }

    public function createdMeetupEvents()
    {
        return $this->hasMany(MeetupEvent::class, 'created_by_id');
    }

    public function asStarMeetupEvents()
    {
        return $this->hasMany(MeetupEvent::class, 'star_id');
    }

    public function registeredMeetupEvents()
    {
        return $this->hasMany(MeetupEventRegistration::class, 'user_id');
    }

    public function asStarLearningSessions()
    {
        return $this->hasMany(LearningSession::class, 'star_id');
    }

    public function registeredLearningSessions()
    {
        return $this->hasMany(LearningSessionRegistration::class, 'user_id');
    }


    public function auditionReacts()
    {
        return $this->hasMany(AuditionReact::class, 'user_id');
    }

    public function auditionComments()
    {
        return $this->hasMany(AuditionComment::class, 'user_id');
    }

    public function createdAuditionEvents()
    {
        return $this->hasMany(AuditionEvent::class, 'created_by_id');
    }

    public function asStarAuditionEvents()
    {
        return $this->hasMany(AuditionEvent::class, 'star_id');
    }

    public function registeredAuditionEvents()
    {
        return $this->hasMany(AuditionEventRegistration::class, 'user_id');
    }

    public function liveChatReacts()
    {
        return $this->hasMany(LiveChatReact::class, 'user_id');
    }

    public function liveChatComments()
    {
        return $this->hasMany(LiveChatComment::class, 'user_id');
    }

    public function createdLiveChats()
    {
        return $this->hasMany(LiveChat::class, 'created_by_id');
    }

    public function asStarLiveChats()
    {
        return $this->hasMany(LiveChat::class, 'star_id');
    }

    public function registeredLiveChats()
    {
        return $this->hasMany(LiveChatRegistration::class, 'user_id');
    }

    public function auction()
    {
        return $this->hasMany(Auction::class, 'created_by_id');
    }

    public function jury()
    {
        return $this->hasOne(JuryBoard::class, 'star_id');
    }

    public function participant_jury(){
        return $this->hasMany(AuditionParticipant::class, 'jury_id');
    }

    public function markingVideo(){
        return $this->hasMany(AuditionMark::class, 'jury_id');
    }


    // all of this below relation is for audition admin user
    public function assignedAudition()
    {
        return $this->hasOne(Audition::class, 'audition_admin_id');
    }
    public function auditionCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}
