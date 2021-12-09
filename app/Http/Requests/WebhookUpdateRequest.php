<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookUpdateRequest extends FormRequest
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
            'url' => 'Адрес для отправки запроса',
            'method' => 'Метод запроса',
            'data' => 'Данные для отправки',
            'enabled' => 'Включение/отключение события',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $enabled = ($this->has('enabled')) ? true : false;
        $this->merge([
            'enabled' => $enabled,
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
            'url' => 'required|url|unique:webhooks,url,'.$this->webhook->id,
            'method' => 'required|in:post,get',
            'data' => 'required|array|min:1',
            'enabled' => 'required|boolean',
        ];
    }
}
