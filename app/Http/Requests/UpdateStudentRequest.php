<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student')->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($studentId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'student_id' => ['required', 'string', 'max:50', Rule::unique('students', 'student_id')->ignore($studentId)],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'grade_level' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive,graduated'],
        ];
    }
}
