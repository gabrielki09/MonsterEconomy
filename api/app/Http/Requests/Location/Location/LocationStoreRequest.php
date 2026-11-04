<?php

namespace App\Http\Requests\Location\Location;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', 'max:120'],
            'cep' => ['sometimes', 'string', 'min:8', 'max:8'],
            'address' => ['sometimes', 'string', 'max:200'],
            'latitude' => ['sometimes', 'string', 'max:200'],
            'longitude' => ['sometimes', 'string', 'max:200'],
            'opening_time' => ['required'],
            'closing_time' => ['required'],
            'notes' => ['sometimes', 'max:500'],
        ];
    }
}
