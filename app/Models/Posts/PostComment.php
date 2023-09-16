<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

use App\Models\Posts\Post;

class PostComment extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

    public function post(){
        // postテーブルとのリレーション 1対多の多の方
        return $this->belongsTo(Post::class);
    }

    public function commentUser($user_id){
        //このコメントをしたユーザーを探す。一致したusersテーブルのレコードを持ってくる。
        return User::where('id', $user_id)->first();
    }

    // コメント数をカウントする（自分で作った）
    public function commentCounts($post_id){
        return $this->where('post_id', $post_id)->get()->count();
    }
}
