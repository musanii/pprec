<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimeTableRequest extends FormRequest
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
        return [
            'academic_year_id' => ['required'],
            'term_id' => ['required'],
            'class_id' => ['required'],
            'stream_id' => ['nullable'],
            'school_period_id' => ['required'],
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
            'day_of_week' => ['required']
        ];
    }
}
