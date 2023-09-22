<?php
namespace App\Searchs;

use App\Models\Users\User;

class AllUsers implements DisplayUsers{

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    //全てのユーザーを取得する。
    $users = User::all();
    return $users;
  }


}
