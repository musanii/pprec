<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $student = $this->route('student');
        return [
            'student_name' => ['required','string','max:255'],
            'admission_no' => ['required','string','max:50', Rule::unique('students','admission_no')->ignore($student->id)],
            'gender' => ['nullable', Rule::in(['male','female'])],
            'status' => ['required', Rule::in(['admitted','active','suspended','alumni'])],

            'parent_name' => ['required','string','max:255'],
            'parent_phone' => ['nullable','string','max:30'],

            // optional: allow changing parent email only if you want it editable
             //'parent_email' => ['required','email','max:255', Rule::unique('users','email')->ignore($student->parent?->user_id)],
        ];
    }
}
