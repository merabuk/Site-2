<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LeadGroupUpdateFieldRequest extends FormRequest
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
            'open' => 'Время начала работы',
            'close' => 'Время завершения работы',
            'k_leads' => 'Коэффициент на количество лидов',
            'max_leads' => 'Максимальное количество лидов',
            'enabled' => 'Включить/Отключить автораспределение лидов',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (! is_null($this->enabled)) {
            $enabled = ($this->enabled) ? true : false ;
            $this->merge([
                'enabled' => $enabled,
            ]);
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
            'name' => 'nullable|string|max:255|unique:lead_groups,name,'.$this->lead_group->id,
            'code' => 'nullable|string|max:255|unique:lead_groups,code,'.$this->lead_group->id,
            'open' => 'nullable|date_format:H:i',
            'close' => 'nullable|date_format:H:i',
            'k_leads' => 'nullable|integer|min:1|max:100',
            'max_leads' => 'nullable|integer|min:1',
            'enabled' => 'nullable|boolean',
        ];
    }
}
