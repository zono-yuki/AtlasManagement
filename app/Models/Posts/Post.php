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
        'created_at',
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

    // コメント数計算
    public function commentCounts($post_id){ //$post_idは投稿のid

        return Post::with('postComments')->find($post_id)->postComments()->get()->count();

        //postsテーブルのidが$post_idであるカラムをfind()で取得する。そのカラムから、リレーションで紐づいている、postCommentsテーブルのpost_idと同じidの数を取得する。(1対多なのでたくさんある。)=コメントの数が出る。

        // return PostComment::where('post_id', $post_id)->get()->count();
        //自作。これでもOKだった。
    }


}
