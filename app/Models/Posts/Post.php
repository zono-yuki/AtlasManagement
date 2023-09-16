<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;
use App\Models\Posts\PostComment;



class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

/////////////////////////////////////////////////////////////////////////////////////////

    public function user(){//usersテーブルとのリレーション(1対多の多の方)
        return $this->belongsTo(User::class);
    }

/////////////////////////////////////////////////////////////////////////////////////////

    public function postComments(){//postCommentsとのリレーション(1対多の1の方)
        return $this->hasMany(PostComment::class);
    }

////////////////////////////////////////////////////////////////////////////////////////

    public function subCategories(){
        // リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
