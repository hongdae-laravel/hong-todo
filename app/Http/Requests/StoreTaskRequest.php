<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required|max:255'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute 은 필수 입력사항입니다.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '할일내용'
        ];
    }
}
