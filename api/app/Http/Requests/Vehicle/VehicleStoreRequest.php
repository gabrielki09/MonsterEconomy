<?php

namespace App\Http\Requests\Vehicle;

use App\Enum\Vehicle\VehicleTypes;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleStoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->filled('model'))
        {
            $this->merge([
                'model' => strtoupper(
                    $this->input('model')
                ),
            ]);
        }

        if ($this->filled('actual_avg')) {
            $this->merge([
                'actual_avg' => str_replace(
                    ',',
                    '.',
                    $this->input('actual_avg')
                ),
            ]);
        }
    }
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
            'model' => ['required', 'string'],
            'actual_avg' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:999.99'],
            'year' => ['required', 'integer'],
            'type' => ['required', Rule::enum(VehicleTypes::class)],
        ];
    }
}
