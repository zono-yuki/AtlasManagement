<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers{

//カテゴリが名前の時
//科目がnullだった場合
//ここでユーザーを検索する。

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(empty($gender)){//性別が空の時,is_nullにする？
      $gender = ['1', '2'];
    }else{//nullではない時
      $gender = array($gender);
    }

    if(empty($role)){//役職がnullの時,is_nullにする？
      $role = ['1', '2', '3', '4'];
    }else{//nullではない時
      $role = array($role);
    }

    //検索処理
    $users = User::with('subjects')
    ->where(function($q) use ($keyword){
      //$keywordが当てはまる名前を検索する。
      $q->where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('over_name_kana', $updown)->get();//並び替え

    return $users;//検索したユーザーを送る
  }
}
