<?php

namespace App\Http\Requests\Vehicle;

use App\Enum\Vehicle\VehicleTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleUpdateRequest extends FormRequest
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
            'model' => ['sometimes', 'string'],
            'actual_avg' => ['sometimes', 'number'],
            'year' => ['sometimes', 'integer'],
            'type' => ['sometimes', Rule::enum(VehicleTypes::class)],
        ];
    }
}
