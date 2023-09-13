<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){//usersテーブルとのリレーション(1対多の多の方)
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){//postCommentsとのリレーション(1対多の1の方)
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        // リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
