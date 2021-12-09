<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UtmParamUpdateRequest extends FormRequest
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
            'name' => 'Название',
            'code' => 'Код',
            'order' => 'Порядок',
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
            'name' => 'required|string|max:255',
            'code' => 'required|alpha_dash|max:50|unique:get_params,code|unique:utm_params,code,'.$this->utm_param->id,
            'order' => 'nullable|numeric',
        ];
    }
}
