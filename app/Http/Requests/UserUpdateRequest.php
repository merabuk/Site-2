<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserUpdateRequest extends FormRequest
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
            // 'userGroups' => 'Группа',
            // 'userGroups.*' => 'Группа',
            'permissions' => 'Разрешение',
            'permissions.*' => 'Разрешение',
        ];
    }

    /**
     * Prepare request data before validation
     */
    protected function prepareForValidation()
    {
        if (!$this->filled('password')) {
            $this->request->remove('password');
        }
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
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|min:8|max:255|confirmed',
            'role' => 'sometimes|required',
            // 'userGroups' => 'nullable|array',
            // 'userGroups.*' => 'distinct',
            'permissions' => 'nullable|array',
            'permissions.*' => 'distinct',
        ];
    }
}
