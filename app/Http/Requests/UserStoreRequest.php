<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserStoreRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Ф.И.О.',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'role' => 'Роль',
            'userGroups' => 'Группа',
            'userGroups.*' => 'Группа',
            'permissions' => 'Разрешение',
            'permissions.*' => 'Разрешение',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed',
            'role' => 'required',
            'userGroups' => 'nullable|array',
            'userGroups.*' => 'distinct',
            'permissions' => 'nullable|array',
            'permissions.*' => 'distinct',
        ];
    }
}
