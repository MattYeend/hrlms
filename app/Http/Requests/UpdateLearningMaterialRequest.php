<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLearningMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('learningMaterial'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $learningMaterial = $this->route('learningMaterial');
        return array_merge(
            $this->basicInfoRules($learningMaterial),
            $this->materialInfoRules(),
            $this->foreignKeyInfoRules()
        );
    }

    /**
     * Helper function to hold basic information.
     *
     * @return array
     */
    private function basicInfoRules($learningMaterial): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:learning_materials,slug,' . $learningMaterial->id,
            ],
        ];
    }

    /**
     * Helper function to hold material based information.
     *
     * @return array
     */
    private function materialInfoRules(): array
    {
        return [
            'key_objectives' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'file' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,ppt,pptx,mp4',
                'max:10240',
            ],
            'url' => ['nullable', 'string'],
        ];
    }

    /**
     * Helper function to hold foreign key information.
     *
     * @return array
     */
    private function foreignKeyInfoRules(): array
    {
        return [
            'learning_provider_id' => [
                'nullable', 'exists:learning_providers,id',
            ],
            'department_id' => ['nullable', 'exists:departments,id'],
        ];
    }
}
