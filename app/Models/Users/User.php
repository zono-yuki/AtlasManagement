<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Posts\Like;

use App\Models\Posts\Post;



use Auth;

use App\Models\Users\Subjects;


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
        'password',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password' , 'remember_token', 'user_id' , 'subject_users',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

/////////////////////////////////////////////////////////////////////////////////////
    public function posts(){//postsテーブルとのリレーション1対多の,1の方。
        return $this->hasMany(Post::class);
    }

    public function likes(){ //likesテーブルとのリレーション1対多の,1の方。
        return $this->hasMany(Like::class);
    }

/////////////////////////////////////////////////////////////////////////////////////

    public function calendars(){ //使わない。
        return $this->belongsToMany('App\Models\Calendars\Calendar', 'calendar_users', 'user_id', 'calendar_id')->withPivot('user_id', 'id');
    }

    public function reserveSettings(){ //スクール予約テーブルとの中間テーブルリレーション
        return $this->belongsToMany('App\Models\Calendars\ReserveSettings', 'reserve_setting_users', 'user_id', 'reserve_setting_id')->withPivot('id');
        //withPivot $user->pivot->idで簡単に中間テーブルのカラムが取得できるようになる
    }

    // 追加  作成中！！ 該当するカレンダーid(reserve_setting_id)を予約しているレコードを全て取得する。
    public function reserveGetUsers(Int $reserve_setting_id){
        // return (bool) $this->reserveSettings()->where('reserve_setting_id',$reserve_setting_id)->get();
        return $this->reserveSettings()->where('reserve_setting_id', $reserve_setting_id)->get();

    }

    public function reserveGetUsers2(Int $user_id, Int $reserve_setting_id)
    {
        // return (bool) $this->reserveSettings()->where('reserve_setting_id',$reserve_setting_id)->get();
        // return (bool) $this->reserveSettings()->where('reserve_setting_id', $reserve_setting_id)->where('user_id', $user_id)->first();
        return (bool) $this->reserveSettings()->where([
            ['user_id', '=' , $user_id],
            ['reserve_setting_id', '=' , $reserve_setting_id],
        ])->first();
    }


///////////////////////////////////////////////////////////////////////////////////////////////////////

    //多対多のリレーションの定義(中間テーブル(subject_usersテーブル)の設定)

    public function subjects()
    {
        return $this->belongsToMany(Subjects::class,'subject_users','user_id','subject_id');
        //ログインユーザーのidがuser_idに入る。
        //attach($subjects)のidがsubject_idに入る。
    }



///////////////////////////////////////////////////////////////////////////////////////////////////////

    // ログインユーザーが投稿にイイネしているかどうか確認する
    public function is_Like($post_id){
        return Like::where('like_user_id', Auth::id())->where('like_post_id', $post_id)->first(['likes.id']);
        //like_user_idは,いいねした人のidのこと
        //like_post_idは,いいねした投稿のidのこと
        //渡されてきた投稿が、自分がいいねした投稿であれば、その投稿のidを取得する

        //likes.idはlikesテーブルのid
    }

    public function likePostId(){//いいねした投稿を検索する
        return Like::where('like_user_id', Auth::id());//リレーション先のLikeテーブルからlike_user_idがログインidの
    }
}
