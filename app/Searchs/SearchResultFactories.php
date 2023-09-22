<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  // 検索
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){//カテゴリが名前の時
      if(is_null($subjects)){//科目がnullだった場合 SelectNames()
        $searchResults = new SelectNames();
      }else{
        //科目が入っていた場合 SelectNameDetails
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
      //resultUsersでキーワードから該当するユーザー(複数いる)を検索する。
    }

    else if($category == 'id'){//カテゴリがidのとき
      if(is_null($subjects)){
        $searchResults = new SelectIds();
      }else{
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }

    else{//カテゴリの入力がなかった場合
      $allUsers = new AllUsers();//全てのユーザーを取得する。
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
