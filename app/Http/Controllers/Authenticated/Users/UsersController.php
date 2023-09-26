<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    //検索画面を表示する処理
    public function showUsers(Request $request){
        // dd($request);
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;

        if(isset($request->subjects) && is_array($request->subjects)){
            $subjects = $request->subjects;
            //科目が選択された時の処理
        }else{
            $subjects = null;
            //科目が選択されなかった時の処理initializeUsers()でif文に入るためnullにしている。
        }
        // dd($subjects);
        //科目を選択したら、1,2,3の数字が配列が受け取れている。

        $userFactory = new SearchResultFactories();

        //SearchResultFactoriesクラスのinitializeUsers()でキーワードなどからユーザーを検索する
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);

        $subjects = Subjects::all();//国語、数学、英語を取得する ここがなんですべていれているのかわからない。

        //検索ページを更新して表示する。
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    ///////////////////////////////////////////////////////////////////////////////////////

    public function userProfile($id){
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
