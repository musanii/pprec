<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferStudentRequest extends FormRequest
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
            'class_id' => ['required', Rule::exists('school_classes','id')],
            'stream_id' => [
                'nullable',
                Rule::exists('streams','id')->where(fn ($q) => $q->where('class_id', $this->input('class_id'))),
            ],
            'reason' => ['nullable','string','max:255'],
        ];
    }
}
