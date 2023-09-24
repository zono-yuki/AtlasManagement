<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers{

  //カテゴリが社員IDのとき
  //科目が入っていた時

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($keyword)){//キーワードが何も入力されていない場合
      $keyword = User::get('id')->toArray();//usersテーブルからidを全部取得する。
    }else{//キーワードが入力されていた場合
      $keyword = array($keyword);
    }
    if(is_null($gender)){//性別
      $gender = ['1', '2'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4', '5'];
    }else{
      $role = array($role);
    }
    $users = User::with('subjects')
    ->whereIn('id', $keyword)
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    ->whereHas('subjects', function($q) use ($subjects){//subjectsテーブルで検索する。
      //whereHas()は、リレーション先のテーブルを検索する。
      $q->where('subjects.id', $subjects);
    })
    ->orderBy('id', $updown)->get();
    return $users;
  }

}
