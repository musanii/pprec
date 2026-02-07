<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStudentRequest extends FormRequest
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

     $request = $this->route('student');
       return  [
            'student_name' => ['required', 'string', 'max:255'],
            'admission_no' => ['required', 'string', 'unique:students,admission_no'],
            'gender' => ['nullable', 'in:male,female'],

            'parent_name' => ['required', 'string', 'max:255'],
            'parent_email' => ['required', 'email', 'unique:users,email'],
            'parent_phone' => ['nullable', 'string'],

            'class_id' => ['required', 'exists:classes,id'],
            'stream_id' => [
                'nullable',
                Rule::exists('streams', 'id')->where(fn ($q) => $q->where('class_id', $request->input('class_id'))),
            
            ], [
            'class_id.required' => 'Please select a class.',
            'class_id.exists' => 'The selected class is invalid.',
            'stream_id.exists' => 'The selected stream is invalid for the chosen class.',

        ]
        
        ];
    }
}
