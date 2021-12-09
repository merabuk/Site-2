<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionSaveRequest extends FormRequest
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
            'auto_leads_ctrl' => 'Автораспределение лидов по группам',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $autoLeadsCtrl = ($this->has('auto_leads_ctrl')) ? true : false;
        $this->merge([
            'auto_leads_ctrl' => $autoLeadsCtrl,
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
            'auto_leads_ctrl' => 'required|boolean',
        ];
    }
}
