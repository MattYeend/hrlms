<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningMaterialRequest;
use App\Http\Requests\UpdateLearningMaterialRequest;
use App\Models\Department;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialUser;
use App\Models\LearningProvider;
use App\Models\User;
use App\Services\LearningMaterialLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class LearningMaterialController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * LearningMaterialLogger instance.
     */
    protected LearningMaterialLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param LearningMaterialLogger $logger
     * An instance of the LearningMaterialLogger used for logging
     * user-related activities
     */
    public function __construct(LearningMaterialLogger $logger)
    {
        $this->authorizeResource(LearningMaterial::class, 'learningMaterial');
        $this->logger = $logger;
    }

    /**
     * Display a paginated list of active learning materials.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny', LearningMaterial::class);

        $this->logger->index(auth()->id());

        $archivedCount = LearningMaterial::onlyTrashed()->count();

        $learningMaterials = LearningMaterial::with(
            ['learningProvider', 'department']
        )
        ->withCount([
            'users as has_activity' => function ($query) {
                $query->whereIn('learning_material_user.status', [
                    LearningMaterialUser::STATUS_STARTED,
                    LearningMaterialUser::STATUS_COMPLETED,
                ]);
            },
        ])
        ->paginate(10);

        return Inertia::render('learningMaterial/Index', [
            'learningMaterials' => $learningMaterials,
            'authUser' => User::where('id', auth()->id())
                ->with('role:id,name')
                ->first(),
            'hasArchivedLearningMaterials' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form to create a new learning material.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', LearningProvider::class);

        $learningMaterials = LearningMaterial::with(
            ['learningProvider', 'department']
        )->get();
        $learningProviders = LearningProvider::with('businessType')->get();
        $departments = Department::with('deptLead')->get();

        return Inertia::render('learningMaterial/Create', [
            'learningMaterials' => $learningMaterials,
            'learningProviders' => $learningProviders,
            'departments' => $departments,
        ]);
    }

    /**
     * Store a new learning material in the database.
     *
     * @param StoreLearningMaterialRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLearningMaterialRequest $request)
    {
        $this->authorize('create', LearningMaterial::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('learning_materials', 'public');
        }

        $learningMaterial = LearningMaterial::create($data);

        $this->logger->create($learningMaterial, auth()->id());

        return redirect()->route('learningMaterials.show', $learningMaterial)
            ->with('success', 'Learning Material created successfully.');
    }

    /**
     * Display the specified learning provider.
     *
     * @param LearningMaterial $learningMaterial
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function show(LearningMaterial $learningMaterial, Request $request)
    {
        $this->authorize('view', $learningMaterial);

        $this->logger->show($learningMaterial, auth()->id());

        $user = auth()->user();

        $pivot = $learningMaterial->users()
            ->where('user_id', $user->id)
            ->first()?->pivot;

        $started = $pivot && (int)$pivot->status !== \App\Models\LearningMaterialUser::STATUS_NOT_STARTED;
        $ended = $pivot && (int)$pivot->status === \App\Models\LearningMaterialUser::STATUS_COMPLETED;

        return Inertia::render('learningMaterial/Show', [
            'learningMaterial' => array_merge(
                $learningMaterial->load(['learningProvider', 'department'])->toArray(),
                [
                    'started' => $started,
                    'ended' => $ended,
                ]
            ),
            'from' => $request->query('from', 'index'),
            'userStatus' => $pivot ? [
                'status' => $pivot->status,
                'completed_at' => $pivot->completed_at,
            ] : null,
        ]);
    }

    /**
     * Show the form for editing a learning provider.
     *
     * @param LearningMaterial $learningMaterial
     *
     * @return \Inertia\Response
     */
    public function edit(LearningMaterial $learningMaterial)
    {
        $this->authorize('update', $learningMaterial);

        $learningMaterial->load(['learningProvider', 'department']);

        return Inertia::render('learningMaterial/Edit', [
            'learningMaterial' => $learningMaterial,
            'learningProviders' => LearningProvider::select('id', 'name')
                ->get(),
            'departments' => Department::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified learning provider.
     *
     * @param UpdateLearningMaterialRequest $request
     * @param LearningMaterial $learningMaterial
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateLearningMaterialRequest $request,
        LearningMaterial $learningMaterial
    ) {
        $this->authorize('update', $learningMaterial);

        $data = $request->validated();

        if ($request->hasFile('file')) {
            $this->replaceFile($learningMaterial);
            $data['file_path'] = $request->file('file')
                ->store('learning_materials', 'public');
        }

        $learningMaterial->update(array_merge($data, [
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]));

        $this->logger->update($learningMaterial, auth()->id());

        return redirect()->route('learningMaterials.show', $learningMaterial)
            ->with('success', 'Learning Material updated successfully.');
    }

    /**
     * Soft-delete (archive) the learning material.
     *
     * @param LearningMaterial $learningMaterial
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LearningMaterial $learningMaterial)
    {
        $this->authorize('delete', $learningMaterial);

        $learningMaterial->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $learningMaterial->delete();

        $this->logger->delete($learningMaterial, auth()->id());

        return redirect()->route('learningMaterials.index')
            ->with('success', 'Learning Material deleted successfully.');
    }

    /**
     * Restore a previously deleted learning material.
     *
     * @param LearningMaterial $learningMaterial
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(LearningMaterial $learningMaterial)
    {
        $this->authorize('restore', $learningMaterial);

        $learningMaterial->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $learningMaterial->restore();

        $this->logger->restore($learningMaterial, auth()->id());

        return redirect()->route(
            'learningMaterials.show',
            $learningMaterial,
        )->with('success', 'Learning Material restored.');
    }

    /**
     * Display a list of archived learning materials.
     *
     * @return \Inertia\Response
     */
    public function archived()
    {
        $this->authorize('viewArchived', LearningMaterial::class);

        $this->logger->archived(auth()->id());

        $learningMaterials = LearningMaterial::onlyTrashed()
            ->with(['learningProvider', 'department'])
            ->paginate(10);

        $authUser = User::where('id', auth()->id())
            ->with('role:id,name')
            ->first();

        return Inertia::render('learningMaterial/Archived', [
            'learningMaterials' => $learningMaterials,
            'authUser' => $authUser,
        ]);
    }

    /**
     * Mark a learning material as started by the authenticated user.
     *
     * @param \App\Models\LearningMaterial $learningMaterial
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(LearningMaterial $learningMaterial): RedirectResponse
    {
        $this->authorize('canStart', $learningMaterial);
        $user = auth()->user();

        $learningMaterial->users()->syncWithoutDetaching([
            $user->id => [
                'status' => LearningMaterialUser::STATUS_STARTED,
                'completed_at' => null,
            ],
        ]);

        return redirect()->route('learningMaterials.show', $learningMaterial->slug);
    }

    /**
     * Mark a learning material as completed by the authenticated user.
     *
     * @param \App\Models\LearningMaterial $learningMaterial
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function end(LearningMaterial $learningMaterial): RedirectResponse
    {
        $this->authorize('canEnd', $learningMaterial);
        $user = auth()->user();

        DB::table('learning_material_user')
            ->where('learning_material_id', $learningMaterial->id)
            ->where('user_id', $user->id)
            ->update([
                'status' => LearningMaterialUser::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);

        return redirect()->route('learningMaterials.show', $learningMaterial->slug);
    }

    /**
     * Deletes the existing file associated with the given learning material
     * from the public storage disk, if it exists.
     *
     * @param \App\Models\LearningMaterial $learningMaterial  The learning
     * material whose file should be replaced.
     *
     * @return void
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
