<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  //カテゴリが名前の時
  //科目が入っていた場合
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      $gender = ['1', '2' ,'3'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }

    $users = User::with('subjects')//UsersテーブルとリレーションしているSubjectsテーブルも使うということ。
    ->where(function($q) use ($keyword){//keywordを使って名前を検索
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    ->where(function($q) use ($role, $gender){//roleとgenderを使って検索
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    ->whereHas('subjects', function($q) use ($subjects){//科目を使って検索する。
      $q->where('subjects.id', $subjects);
    })
    ->orderBy('over_name_kana', $updown)->get();
    return $users;
  }

}
