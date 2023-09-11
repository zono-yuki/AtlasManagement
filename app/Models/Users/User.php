<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Like;
use Auth;
use App\Models\Users\subjects;


class User extends Authenticatable
{
    use Notifiable;
    use softDeletes;

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'over_name',
        'under_name',
        'over_name_kana',
        'under_name_kana',
        'mail_address',
        'sex',
        'birth_day',
        'role',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password' , 'remember_token', 'user_id' , 'subject_users'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function calendars(){
        return $this->belongsToMany('App\Models\Calendars\Calendar', 'calendar_users', 'user_id', 'calendar_id')->withPivot('user_id', 'id');
    }

    public function reserveSettings(){
        return $this->belongsToMany('App\Models\Calendars\ReserveSettings', 'reserve_setting_users', 'user_id', 'reserve_setting_id')->withPivot('id');
    }
///////////////////////////////////////////////////////////////////////////////////////////////////////

    //多対多のリレーションの定義
    public function subjects(){
        // return $this->belongsToMany(Subjects::class, 'subject_users', 'user_id', 'subject_id');

        return $this->belongsToMany('App\Users\User', 'subject_users', 'user_id', 'subject_id');
        //ログインユーザーのid,選択科目のid
    }

    public function users()
    {
        return $this->belongsToMany('App\Users\User', 'subject_users', 'subject_id', 'user_id');
        //選択科目のid,ログインユーザーのid
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////

    // いいねしているかどうか
    public function is_Like($post_id){
        return Like::where('like_user_id', Auth::id())->where('like_post_id', $post_id)->first(['likes.id']);
    }

    public function likePostId(){
        return Like::where('like_user_id', Auth::id());
    }
}
