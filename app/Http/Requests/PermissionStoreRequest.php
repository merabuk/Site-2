<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PermissionStoreRequest extends FormRequest
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
            'name' => 'Кодировка',
            'display_name' => 'Название',
            'description' => 'Описание',
            'icon' => 'Иконка',
            'permission_group_id' => 'Группа разрешений',
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
            'display_name' => 'required|string|max:255|unique:permissions,display_name',
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'permission_group_id' => 'required',
        ];
    }
}
