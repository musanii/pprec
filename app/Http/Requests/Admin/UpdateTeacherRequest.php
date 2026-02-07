<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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

    $teacher = $this->route('teacher');

   
        return [
             'name' => ['required','string','max:255'],
            'staff_no' => ['required','string',"unique:teachers,staff_no,{$teacher->id}"],
            'phone' => ['nullable','string'],
            'gender' => ['nullable','in:male,female'],
            'is_active' => ['boolean'],
        ];
    }
}
