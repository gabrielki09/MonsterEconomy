<?php

namespace App\Http\Requests\Monster;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class MonsterProductStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:7', 'max:120'],
            'volume_ml' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],

            'prices' => [
                'sometimes',
                'nullable',
                'array'
            ],
            'prices.*' => [
                'required',
                'array:location_id,unit_price'
            ],

            'prices.*.location_id' => ['sometimes', 'nullable', 'exists:locations,id', 'integer', 'distinct',],
            'prices.*.unit_price' => ['required', 'numeric', 'decimal:0,2', 'gt:0', 'max:999.99'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string' => 'O nome do produto deve ser um texto válido.',
            'name.min' => 'O nome do produto deve ter no mínimo :min caracteres.',
            'name.max' => 'O nome do produto deve ter no máximo :max caracteres.',

            'volume_ml.required' => 'O volumne por Ml da lata é obrigatório.',
            'volume_ml.numeric' => 'O volumne por Ml da lata deve ser um número válido.',
            'volume_ml.decimal' => 'O volumne por Ml da lata deve ser ter no máximo duas casas decimais.',
            'volume_ml.min' => "O volumne por Ml da lata deve ter no mínimo :min ml's.",
            'volume_ml.max' => "O volumne por Ml da lata deve ter no máximo :max ml's.",

            'prices.array' => 'Os preços devem ser enviados em uma lista.',
            'prices.min' => 'Informe pelo menos um preço.',

            'prices.*.location_id.exists' => 'A localização informada não foi localizada.',
            'prices.*.location_id.integer' => 'O indetificador da localização deve ser um número inteiro válido.',
            'prices.*.location_id.distinct' => 'O indetificador da localização deve ser único por preço.',

            'prices.*.unit_price.required' => 'O valor unitário do Monster é obrigatório.',
            'prices.*.unit_price.numeric' => 'O valor unitário do Monster deve ser um número válido.',
            'prices.*.unit_price.decimal' => 'O valor unitário do Monster deve ser ter no máximo duas casas decimais.',
            'prices.*.unit_price.gt' => 'O valor unitário do Monster deve ter maior que R$ 0,00.',
            'prices.*.unit_price.max' => 'O valor unitário do Monster deve ter no máximo R$ :max.',
        ];
    }
}
