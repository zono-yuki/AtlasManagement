<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubFormRequest extends FormRequest
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
        //サブカテゴリーのバリデーションルール
        return [
            //登録されているメインカテゴリーかどうかも加える。
            // 'main_category_id' => 'required|',
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ];
    }

    public function messages()
    {
        return [ //メインカテゴリーのエラーメッセージ
            'main_category_id.required' => 'メインカテゴリーは必ず入力してください。',
            'main_category_id.exists' => '登録されているメインカテゴリーを選択してください。',


            'sub_category_name.required' =>'サブカテゴリーは必ず入力してください。',
            'sub_category_name.max' => 'サブカテゴリーは100文字以内で入力して下さい。',
            'sub_category_name.unique' => '登録済みのサブカテゴリーです。',
        ];
    }
}
