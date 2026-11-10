<?php

namespace App\Http\Requests\Monster;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MonsterUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:7', 'max:120'],
            'volume_ml' => ['sometimes', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],

            'prices' => ['sometimes', 'nullable', 'array'],
            'prices.*' => [
                'array:location_id,unit_price,available'
            ],

            'prices.*.location_id' => ['sometimes', 'nullable', 'exists:locations,id', 'integer'],
            'prices.*.unit_price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O nome do produto deve ser um texto válido.',
            'name.min' => 'O nome do produto deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome do produto deve ter no máximo :max caracteres.',

            'volume_ml.numeric' => 'O volumne por Ml da lata deve ser um número válido.',
            'volume_ml.decimal' => 'O volumne por Ml da lata deve ser ter no máximo duas casas decimais.',
            'volume_ml.min' => "O volumne por Ml da lata deve ter no mínimo :min ml's.",
            'volume_ml.max' => "O volumne por Ml da lata deve ter no máximo :max ml's.",

            'prices.array' => 'O dados do preço do Monster devem ser enviados em uma lista.',

            'prices.*.location_id.exists' => 'A localização informada não foi localizada.',
            'prices.*.location_id.integer' => 'O indetificador da localização deve ser um número inteiro válido.',
            'prices.*.unit_price.required' => 'O valor unitário do Monster é obrigatório.',
            'prices.*.unit_price.numeric' => 'O valor unitário do Monster deve ser um número válido.',
            'prices.*.unit_price.decimal' => 'O valor unitário do Monster deve ser ter no máximo duas casas decimais.',
            'prices.*.unit_price.min' => 'O valor unitário do Monster deve ter no mínimo R$ :min.',
            'prices.*.unit_price.max' => 'O valor unitário do Monster deve ter no máximo R$ :max.',
        ];
    }
}
