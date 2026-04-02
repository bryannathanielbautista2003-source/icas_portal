<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentModuleRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->role === 'student';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'module_name' => ['required', 'string', 'max:255'],
            'module_code' => ['required', 'string', 'max:50'],
            'instructor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'module_name.required' => 'Please provide a module name.',
            'module_code.required' => 'Please provide a module code.',
            'module_name.max' => 'The module name must not be greater than 255 characters.',
            'module_code.max' => 'The module code must not be greater than 50 characters.',
        ];
    }
}
