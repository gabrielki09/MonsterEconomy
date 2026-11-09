<?php

namespace App\Http\Requests\Filters;

use App\Enum\Filters\FilterV1Types;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterV1Request extends FormRequest
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
            'per_page' => [
                'sometimes',
                'integer',
                'min:1'
            ],

            'relationships' => [
                'sometimes',
                'array',
                'max:100'
            ],

            'relationships.*' => [
                'sometimes',
                'string'
            ],

            'filtersV1' => [
                'sometimes',
                'array',
            ],

            'filtersV1.*' => [
                'array:field,filterType,filterValue'
            ],

            'filtersV1.*.field' => [
                'required',
                'string',
            ],

            'filtersV1.*.filterType' => [
                'required',
                Rule::enum(FilterV1Types::class)
            ],

            'filtersV1.*.filterValue' => [
                'nullable'
            ],
        ];
    }

    public function messages()
    {
        return [
            'per_page.integer' => 'A quantidade por página deve ser um número inteiro.',

            'per_page.min' => 'A quantidade por página deve ser maior ou igual a 1.',

            'per_page.max' => 'A quantidade por página não pode ser maior que :max.',

            'relationships.array' => 'Os relacionamentos devem ser enviados como uma lista.',

            'relationships.max' => 'Não é permitido carregar mais de :max relacionamentos.',

            'relationships.*.string' => 'Um relacionamento deve ser um texto válido.',
            'relationships.*' => 'Um relacionamento deve ser um texto válido.',

            'filtersV1.array' => 'Os filtros devem ser enviados como uma lista.',

            'filtersV1.*' => 'Um filtro deve ser um campo, um tipo de campo ou um valor.',

            'filtersV1.*.field.required' => 'O campo do filtro deve ser informado.',
            'filtersV1.*.field.string' => 'O campo do filtro deve ser um texto válido.',

            'filtersV1.*.filterType.required' => 'O tipo de filtro deve ser informado.',
            'filtersV1.*.filterType.enum' => 'O tipo de filtro deve ser um filtro válido.',
        ];
    }
}
