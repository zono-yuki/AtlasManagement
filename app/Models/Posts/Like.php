<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;


class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    //いいね数をカウントする
    public function likeCounts($post_id){
        return $this->where('like_post_id', $post_id)->get()->count();
    }

    public function user()
    { //usersテーブルとのリレーション(1対多の多の方)
        return $this->belongsTo(User::class);
    }
}
