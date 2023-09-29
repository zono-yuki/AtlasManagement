<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainFormRequest extends FormRequest
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
        //メインカテゴリーのバリデーションルール
        return [
            'main_category_name' => 'required|string|max:100',
        ];
    }
    public function messages()
    {
        return [ //メインカテゴリーのエラーメッセージ
            'main_category_name.required' => 'メインカテゴリーは必ず入力してください。',
            'main_category_name.max' => 'メインカテゴリーは100文字以内で入力してください。',
        ];
    }

}
