<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrposalRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description'    => ['required', 'string'],
            'cost'           => ['required', 'numeric', 'min:1'],
            'duration'       => ['required', 'integer', 'min:1'],
            'duration_unit'  => ['required', 'in:day,week,month,year'],
        ];
    }
}
