<?php

namespace App\Http\Requests\Admin;

use App\Models\Subject;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    protected function prepareForValidation(): void
{
    $this->merge([
        'is_active' => $this->boolean('is_active'),
        'is_core'   => $this->boolean('is_core'),
    ]);
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    $subject = $this->route('subject'); // <-- route parameter name

    return [
        'name' => ['required', 'string', 'max:120'],
        'code' => [
            'required',
            'string',
            'max:20',
            Rule::unique('subjects', 'code')->ignore($subject?->id),
        ],
        'is_core' => ['nullable', 'boolean'],
        'is_active' => ['nullable', 'boolean'],
    ];
}
}
