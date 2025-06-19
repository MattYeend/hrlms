<?php

namespace App\Services;

use App\Http\Requests\StoreLearningMaterialRequest;
use App\Http\Requests\UpdateLearningMaterialRequest;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LearningMaterialService
{
    /**
     * Create a new LearningMaterial from request.
     */
    public function create(
        StoreLearningMaterialRequest $request,
        int $userId
    ): LearningMaterial {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = $userId;

        if ($request->hasFile('file')) {
            $data['file_path'] =
                $request->file('file')->store('learning_materials', 'public');
        }

        return LearningMaterial::create($data);
    }

    /**
     * Update existing LearningMaterial.
     */
    public function update(
        UpdateLearningMaterialRequest $request,
        LearningMaterial $learningMaterial,
        int $userId
    ): LearningMaterial {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $this->replaceFile($learningMaterial);
            $data['file_path'] =
                $request->file('file')->store('learning_materials', 'public');
        }

        $learningMaterial->update(array_merge($data, [
            'updated_by' => $userId,
            'updated_at' => now(),
        ]));

        return $learningMaterial;
    }

    /**
     * Replace the file for a learning material.
     */
    protected function replaceFile(LearningMaterial $learningMaterial): void
    {
        if (
            $learningMaterial->file_path &&
            Storage::disk('public')->exists($learningMaterial->file_path)
        ) {
            Storage::disk('public')->delete($learningMaterial->file_path);
        }
    }
}
