<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->role_id === \App\Models\Role::SUPER_ADMIN ||
               auth()->user()?->role_id === \App\Models\Role::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $job = $this->route('job');
        return [
            'job_title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:user_jobs,slug,' . $job->id,
            ],
            'short_code' => [
                'nullable',
                'string',
                'max:10',
                'unique:user_jobs,short_code,' . $job->id,
            ],
            'description' => ['nullable', 'string'],
            'is_default' => ['boolean'],
            'department_id' => [
                'exists:departments,id',
            ],
        ];
    }
}
