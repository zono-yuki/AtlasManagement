<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];


///////////////////////////////////////////////////////////////////////////////////////////////////////

//多対多のリレーションの定義
    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_users', 'subject_id', 'user_id');


        //選択科目のid,ログインユーザーのid
    }


///////////////////////////////////////////////////////////////////////////////////////////////////////
}
