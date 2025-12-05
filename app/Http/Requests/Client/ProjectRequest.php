<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'in:fixed,hourly'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Summary of messages
     * @return array{budget.min: string, budget.numeric: string, description.required: string, title.required: string, type.in: string, type.required: string}
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'description.required' => 'The project description is required.',
            'type.required' => 'The project type is required.',
            'type.in' => 'The selected project type is invalid. Choose either fixed or hourly.',
            'budget.numeric' => 'The budget must be a number.',
            'budget.min' => 'The budget must be at least 0.',
        ];
    }
}
