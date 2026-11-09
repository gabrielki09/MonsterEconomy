<?php

namespace App\Http\Requests\Location\Location;

use App\Enum\Days\WeekDay;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationStoreRequest extends FormRequest
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
            'consult_by_cep' => [
                'required',
                'boolean'
            ],

            'cep' => [
                Rule::excludeIf(
                    fn() => !$this->boolean('consult_by_cep')
                ),
                'required',
                'string',
                'regex:/^\d{8}$/'
            ],

            'name' => [
                'required',
                'string',
                'min:3',
                'max:120'
            ],

            'road' => [
                Rule::excludeIf(
                    fn() => $this->boolean('consult_by_cep')
                ),
                'required',
                'string',
                'min:2',
                'max:200'
            ],

            'address' => [
                Rule::excludeIf(
                    fn() => $this->boolean('consult_by_cep')
                ),
                'required',
                'string',
                'min:2',
                'max:200'
            ],

            'latitude' => [
                Rule::excludeIf(
                    fn() => $this->boolean('consult_by_cep')
                ),
                'sometimes',
                'nullable',
                'numeric',
                'between:-90,90'
            ],

            'longitude' => [
                Rule::excludeIf(
                    fn() => $this->boolean('consult_by_cep')
                ),
                'sometimes',
                'nullable',
                'numeric',
                'between:-180,180'
            ],

            'opening_day' => [
                'required',
                Rule::enum(WeekDay::class)
            ],

            'opens_at' => [
                'required_with:closes_at',
                'date_format:H:i'
            ],

            'closes_at' => [
                'required_with:opens_at',
                'date_format:H:i',
                'after:opens_at'
            ],

            'notes' => [
                'sometimes',
                'nullable',
                'string',
                'max:500'
            ],

            'shares_more_than_one_location' => [
                'required',
                'boolean'
            ]
        ];
    }

    public function messages()
    {
        return [
            'consult_by_cep.required' => 'Consulta por CEP deve estar ativada ou desativada.',
            'consult_by_cep.boolean' => 'Consulta por CEP deve ser verdadeiro ou falso',

            'name.required' => 'A descrição do local é obrigatório quando consulta por CEP está desativada.',
            'name.string' => 'A descrição do local deve ser um texto válido.',
            'name.min' => 'A descrição do local deve ter no mínimo :min caracteres.',
            'name.max' => 'A descrição do local deve ter no máximo :max caracteres.',

            'cep.required' => 'O CEP da localização é obrigatório quando consulta por CEP está ativada.',
            'cep.string' => 'O CEP da localização deve ser um texto válido.',
            'cep.regex' => 'O CEP deve conter exatamente 8 números.',

            'road.required' => 'A rua da localização é obrigatório quando consulta por CEP está desativada.',
            'road.string' => 'A rua da localização deve ser um texto válido.',
            'road.min' => 'A rua da localização deve ter no mínimo :min caracteres.',
            'road.max' => 'A rua da localização deve ter no máximo :max caracteres.',

            'address.required' => 'O endereço da localização é obrigatório quando consulta por CEP está desativada.',
            'address.string' => 'O endereço da localização deve ser um texto válido.',
            'address.min' => 'O endereço da localização deve ter no mínimo :min caracteres.',
            'address.max' => 'O endereço da localização deve ter no máximo :max caracteres.',

            'latitude.numeric' => 'A latiduda da localização deve ser um número válido.',
            'latitude.between' => 'A latiduda da localização deve ser entre -90 e 90.',

            'longitude.numeric' => 'A longitude deve ser um número válido.',
            'longitude.between' => 'A longitude  da localização deve ser entre -180 e 180.',

            'opening_day.required' => 'A data de abertura deve ser informada.',
            'opening_day.enum' => 'A data de abertura deve ser um número inteiro entre 1 e 7.',

            'opens_at.required_with' => 'O horário de abertura deve ser informado junto com o horário de fechamento.',
            'opens_at.date_format' => 'O horário de abertura deve estar no formato H:i.',

            'closes_at.required_with' => 'O horário de fechamento deve ser informado junto com o horário de abertura.',
            'closes_at.date_format' => 'O horário de fechamento deve estar no formato H:i.',
            'closes_at.after' => 'O horário de fechamento deve ser posterior ao horário de abertura.',

            'notes.max' => 'As observações da localização deve ter no máximo :max caracteres.',

            'shares_more_than_one_location.required' => 'O indicativo de se a localização compartilha mais de um local deve ser informado.',
            'shares_more_than_one_location.boolean' => 'O indicativo de se a localização compartilha mais de um local deve ser verdadeiro ou falso.'
        ];
    }
}
