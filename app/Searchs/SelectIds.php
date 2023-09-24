<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIds implements DisplayUsers{

  // カテゴリが社員idのとき
  // 科目がnullのとき

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);//$genderがあった場合、変数に設定する
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    if(is_null($keyword)){//キーワードがなかった場合
      $users = User::with('subjects')
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }else{//キーワードが入力されていた場合
      $users = User::with('subjects')
      ->where('id', $keyword)//キーワードで検索する
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }
    return $users;
  }

}
