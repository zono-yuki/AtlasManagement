<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
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

            'comment' => 'required|string|max:2500',

        ];
    }


    public function messages()
    {
        return [ //投稿のエラーメッセージ

            'comment.required' => 'コメントは必ず入力してください。',
            'comment.max' => 'コメントは2500文字以内で入力してください。',

        ];
    }
}
