<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateGimcana extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'theme_id' => ['nullable', 'exists:themes,id'],
            'type' => ['required', 'string', 'max:50'],
            'locations' => ['required', 'array', 'min:1'],
            'locations.*.name' => ['required', 'string', 'max:255'],
            'locations.*.description' => ['nullable', 'string'],
            'locations.*.statement' => ['required', 'string'],
            'locations.*.question_type' => ['required', 'in:open,multiple_choice,true_false'],
            'locations.*.correct_answer' => ['required_if:locations.*.question_type,multiple_choice,true_false', 'string'],
            'locations.*.answers' => ['required_if:locations.*.question_type,multiple_choice', 'array', 'min:2'],
            'locations.*.answers.*' => ['required_if:locations.*.question_type,multiple_choice', 'string', 'max:255'],
            'locations.*.latitude' => ['nullable', 'numeric'],
            'locations.*.longitude' => ['nullable', 'numeric'],
            'locations.*.type' => ['nullable', 'string', 'max:50'],
            'locations.*.file' => ['nullable', 'string', 'max:255'],
            'locations.*.order' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
