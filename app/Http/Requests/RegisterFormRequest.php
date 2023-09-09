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
    public function rules()
    {
        return [
            //'項目名' => '検証ルール｜検証ルール｜検証ルール',
            'over_name' => 'required|string|max:10',

            'under_name' => 'required|string|max:10',

            //カタカナのみ（検索したらこれだった）
            'over_name_kana' => 'required|string|max:30|regex:/^[ ア-ン゛゜ァ-ォャ-ョー]+$/u',

            'under_name_kana' => 'required|string|max:30|regex:/^[ ア-ン゛゜ァ-ォャ-ョー]+$/u',

            'mail_address' => 'required|string|max:100|unique:users,mail_address|email',

            /////////////////
            // 'sex' => 'exclude_unless:check,true|required|string',
            //繋げ方がわからないが2行にする
            //男性、女性、その他、意外は無効 valueの数字を入れる。
            //   ^・は・・先頭一致
            //   $  は   終端一致

            'sex' => 'required|string|regex:/^[1-3]+$/', //この中に1,2,3しか受け付けないのを書く。
            // 'sex' => 'required|string|between:1,3',



            //ここわからない
            'old_year' => 'required|',
            //2000年1月1日から今日まで、正しい日付かどうか（例:2/31や6/31はNG）
            'old_month' => 'required|',
            'old_day' => 'required|',

            // 'role' => 'exclude_unless:check,true|required|string',
            //繋げ方がわからないが2行にする
            //・講師(国語)、講師(数学)、教師(英語)、生徒、以外は無効 valueの数字を入れる。
            'role' => 'required|string|regex:/^[1-4]+$/',



            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|min:8|max:30|confirmed:password',

            'password_confirmation' => 'required|regex:/^[a-zA-Z0-9]+$/|min:8|max:30',
            //確認用のパスワードのnameをpassword_confirmationに変える？
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

            'old_year.required' => '年は入力必須です',
            //2000年1月1日から今日まで、正しい日付かどうか

            'old_month.required' => '月は入力必須です',


            'old_day.required' => '日は入力必須です',

            'role.required' => '役職は入力必須です',



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
