<?php

namespace App\Http\Requests;

use App\Models\GetParam;
use App\Models\UtmParam;
use Illuminate\Foundation\Http\FormRequest;

class LeadUpdateRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            '*.required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно другое поле не заполнено.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //Гет параметры, которые нужно парсить в запросе
        $getParams = GetParam::pluck('code');
        $utmParams = UtmParam::pluck('code');
        //Массив параметров, которые нужно парсить в запросе
        $params = $getParams->merge($utmParams);
        //Меняем значения и ключи местами
        $rules = $params->flip();
        //Записываем вместо бывших ключей правила валидации
        $rules = $rules->map(function ($item, $key) use ($params) {
            return $item = 'required_without_all:'.$params->except($item)->implode(',');
        })->toArray();
        //Валидируем в соответствии с правилами
        return $rules;
    }
}
