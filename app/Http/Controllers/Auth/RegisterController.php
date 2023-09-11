<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;

use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();//科目名を全部取得する処理

        return view('auth.register.register', compact('subjects'));
    }



    //新規登録ボタンを押した時の処理
    public function registerPost(RegisterFormRequest $request)
    //フォームリクエストから受け取る。バリデーション処理

    //【Laravelのトランザクション】
    // クロージャーの中の処理で例外が発生すると自動でロールバックされクロージャーの中で返した値がtransactionメソッドの返り値にできる
    {
        DB::beginTransaction();
        try{

            //生年月日のvalueを受け取る処理
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;

            //日付をまとめて、ハイフンをつける処理
            $data = $old_year . '-' . $old_month . '-' . $old_day;

            $birth_day = date('Y-m-d', strtotime($data));
            //引数2つの時：「第2引数のタイムスタンプ」(上でハイフンをつけた変数$data)を「指定したフォーマット(第1引数)'Y-m-d'」で出力する処理
            //strtotime($dataをUNIXタイムスタンプに変換する)

            // dd($birth_day);
            //2003-01-01 入っている

            //register.blade.phpの  'name="subject[]'を受け取る。subjectはsubject[]のこと。(valueには'$subject->id'が入っている。)
            $subjects = $request->subject;//科目を取得する

            // dd($subjects);
            //0 => "1"

            //新規登録処理したものを$user_getに入れる処理
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,//上記で$birth_dayをbirth_dayカラムに入れ込む
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);

            //
            $user = User::findOrFail($user_get->id);
            //findはidでユーザーを探す
            //違いとしては、もしidが見つからなかった時に
            //find()：nullを返す。
            //findOrFail()：エラー（404HTTPレスポンス）を返す。例外処理。

            // dd($user);


            //$userには、新規登録したユーザー情報が入っている。
            //$subjectsには、選択科目のidが入っている。
            //中間テーブルに紐づける処理($userのidをuser_idに,$subjectsのidをsubject_idとして中間テーブルに登録(attach())する処理
            //$user->subjects()で、中間テーブルにアクセルする。
            $user->subjects()->attach($subjects);

            //トランザクション（一連の処理）で実行した処理を確定（コミット）して終了する記述
            DB::commit();

            //ログイン画面に遷移
            return view('auth.login.login');

        }catch(\Exception $e){

            //失敗したら、登録せずにロールバック(トランザクションのすべてを破棄)する処理。
            DB::rollback();

            //ログイン画面へ
            return redirect()->route('loginView');
        }
    }
}
