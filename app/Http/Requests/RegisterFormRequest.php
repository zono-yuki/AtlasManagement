<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//use Rule追加した。
use Illuminate\Validation\Rule;


class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */



     //バリデーションをかける前に,バラバラに渡された変数を,日付の形にして,rules()に送る処理
    public function getValidatorInstance(){
    //生年月日をまとめて直に渡す
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');


        $datetime = $old_year .'-'. $old_month .'-'. $old_day;
        //ハイフンをつけて日付を作る処理(2023-09-10)

        //rules()に渡す処理
        $this->merge([
            'datetime_validation' => $datetime,
        ]);

        return parent::getValidatorInstance();
        //ここで定義した変数はここでしか使えないようにしている(parentで返しているのがこのメソッドなので)

    }



    public function rules()
    {
        return [
            //'項目名' => '検証ルール｜検証ルール｜検証ルール',
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',

            'over_name_kana' =>'required|string|max:30|regex:/^[ ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'under_name_kana' =>'required|string|max:30|regex:/^[ ア-ン゛゜ァ-ォャ-ョー]+$/u',

            'mail_address' => 'required|string|max:100|unique:users,mail_address|email',

            // 'sex' => 'required|string|regex:/^[1-3]+$/',
            'sex' => 'required|in:1,2,3',

            'datetime_validation' => 'required|date|after:1999-12-31|before:tomorrow',

            // 'role' => 'required|string|regex:/^[1-4]+$/',
            'role' => 'required|in:1,2,3,4',

            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|min:8|max:30|confirmed:password',
            'password_confirmation' => 'required|regex:/^[a-zA-Z0-9]+$/|min:8|max:30',
        ];
    }

    public function messages()
    {
        return [
            //'項目名.検証ルール' => 'メッセージ',
            'over_name.required' => '名前（姓）は必ず入力してください。',
            'over_name.max' => '名前（姓）は10文字以下で入力して下さい。',

            'under_name.required' => '名前（名）は必ず入力してください。',
            'under_name.max' => '名前（名）は10文字以下で入力して下さい。',

            'over_name_kana.required' => 'フリガナ（姓）は入力必須です。',
            'over_name_kana.max' => 'フリガナ（姓）は30文字以下で入力して下さい。',
            'over_name_kana.regex' => 'フリガナ（姓）はカタカナで入力して下さい。',

            'under_name_kana.required' => 'フリガナ（名）は入力必須です。',
            'under_name_kana.max' => 'フリガナ（名）は30文字以下で入力して下さい。',
            'under_name_kana.regex' => 'フリガナ（名）はカタカナで入力して下さい。',

            'mail_address.required' => 'メールアドレスは入力必須です。',
            'mail_address.max' => 'メールアドレスは100文字以下で入力して下さい。',
            'mail_address.unique' => '登録済みのメールアドレスは使用不可です。',
            'mail_address.email' => 'メールアドレスの形式で入力して下さい。',

            'sex.required' => '性別は入力必須です。',
            'sex.regex' => '性別は"男性" "女性" "その他" から選んでください。',

            'datetime_validation.date' => "有効な日付に直してください。",
            'datetime_validation.after' => "2000年1月1日から今日までの日付を入力してください。",
            'datetime_validation.before' => "2000年1月1日から今日までの日付を入力してください。",

            'role.required' => '役職は入力必須です',
            'role.regex' => '役職は "教師(国語)" "教師(数学)" "教師(英語)" から選んでください。',



            'password.required' => 'パスワードは入力必須です。',
            'password.regex' => 'パスワードは英数字のみで入力して下さい。',
            'password.min' => 'パスワードは8文字以上で入力して下さい。',
            'password.max' => 'パスワードは30文字以下で入力して下さい。',
            'password.confirmed' => 'パスワードが一致しません。',

            'password_confirmation.required' => 'パスワード（確認）は入力必須です。',
            'password_confirmation.regex' => 'パスワード(確認)は英数字のみで入力して下さい。',
            'password_confirmation.min' => 'パスワード（確認）は8文字以上で入力して下さい。',
            'password_confirmation.max' => 'パスワード（確認）は30文字以下で入力して下さい。',
            'password_confirmation.confirmed' => 'パスワード（確認）が一致しません。',
        ];
    }
}
