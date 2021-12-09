<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PermissionUpdateRequest extends FormRequest
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
            'display_name' => 'Название',
            'description' => 'Описание',
            'icon' => 'Иконка',
            'permission_group_id' => 'Группа разрешений',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->request->remove('name');
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
            'display_name' => 'required|string|max:255|unique:teams,display_name,'.$this->permission->id,
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'permission_group_id' => 'required',
        ];
    }
}
