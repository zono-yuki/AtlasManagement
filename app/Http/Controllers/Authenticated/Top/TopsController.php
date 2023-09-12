<?php

namespace App\Http\Controllers\Authenticated\Top;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TopsController extends Controller
{
    //トップ画面を表示する処理
    public function show(){
        return view('authenticated.top.top');
    }

    //ログアウトする処理
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
