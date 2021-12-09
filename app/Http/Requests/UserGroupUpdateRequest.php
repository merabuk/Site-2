<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UserGroupUpdateRequest extends FormRequest
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
            'permissions' => 'Разрешение',
            'permissions.*' => 'Разрешение',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => Str::slug($this->display_name),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => 'required|string|max:255|unique:user_groups,display_name,'.$this->user_group->id,
            'name' => 'required|string|max:255|unique:user_groups,name,'.$this->user_group->id,
            'description' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'distinct',
        ];
    }
}
