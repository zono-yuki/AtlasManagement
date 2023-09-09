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
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }



    //新規登録ボタンを押した時の処理
    public function registerPost(RegisterFormRequest $request)
    //フォームリクエストから受け取る。バリデーション
    //【Laravelのトランザクション】
    // クロージャーの中の処理で例外が発生すると自動でロールバックされクロージャーの中で返した値がtransactionメソッドの返り値にできる
    {
        DB::beginTransaction();
        try{
            //参考サイトから引用
            // $date = $request->date;

            // list($year, $month, $day) = explode('-', $date);ハイフンを取り除く

            // if (checkdate($month, $day, $year)) {
            //     echo "true";
            // } else {
            //     echo "false";
            // }


            //生年月日のvalueを受け取る処理
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;

            //ハイフンをつける処理
            $data = $old_year . '-' . $old_month . '-' . $old_day;

            //ハイフンを取り除く処理  (今回ハイフンは$old_yearなどに、はいっていないからいらないかも？？？)
            list($year, $month, $day) = explode('-', $data);

            //日付の妥当性をチェックする処理
            if (checkdate($old_month, $old_day, $old_year)) {
                echo "true";
            } else {
                echo "false";
                return 'NG : 日付が正しくありません。';
            }


            $birth_day = date('Y-m-d', strtotime($data));
            //引数2つの時：「第2引数のタイムスタンプ」(上でハイフンをつけた変数$data)を「指定したフォーマット(第1引数)'Y-m-d'」で出力する処理

            //ro
            $subjects = $request->subject;


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
            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
