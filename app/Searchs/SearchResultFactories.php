<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 選択科目の検索機能
  // 検索処理
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if($category == 'name'){//カテゴリが名前の時
      if(is_null($subjects)){//科目がnullだった場合 SelectNamesクラスを作る。
        $searchResults = new SelectNames();
      }else{
        //科目が入っていた場合 SelectNameDetailsクラスを作る。
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
      //resultUsersでキーワードから該当するユーザー(複数いる)を検索する。
    }

    else if($category == 'id'){//カテゴリが社員idのとき
      if(is_null($subjects)){//科目がnullだった場合 SelectIdsクラスを作る
        $searchResults = new SelectIds();
      }else{
        $searchResults = new SelectIdDetails();//科目が入っていた場合 SelectIdDetailsクラスを作る。
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }

    else{//カテゴリの入力がなかった場合
      $allUsers = new AllUsers();//全てのユーザーを取得する。
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
