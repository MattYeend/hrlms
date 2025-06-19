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
use App\Services\LearningMaterialService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LearningMaterialController extends Controller
{
    /**
     * Declare a protected property to hold the
     * LearningMaterialLogger instance.
     * Declare a protected property to hold the
     * LearningMaterialServise instance.
     */
    protected LearningMaterialLogger $logger;
    protected LearningMaterialService $learningMaterialService;

    /**
     * Constructor for the controller
     *
     * @param LearningMaterialLogger $logger
     * An instance of the LearningMaterialLogger used for logging
     * user-related activities
     *
     * @param LearningMaterialService $learningMaterialService
     * An instance of learningMaterialService used for general
     * user-related activities
     */
    public function __construct(
        LearningMaterialLogger $logger,
        LearningMaterialService $learningMaterialService
    ) {
        $this->authorizeResource(LearningMaterial::class, 'learningMaterial');
        $this->logger = $logger;
        $this->learningMaterialService = $learningMaterialService;
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

        $archivedCount = $this->getArchivedCount();
        $learningMaterials = $this->getPaginatedLearningMaterials();
        $authUser = $this->getAuthUserWithRole();

        return Inertia::render('learningMaterial/Index', [
            'learningMaterials' => $learningMaterials,
            'authUser' => $authUser,
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

        $learningMaterial = $this->learningMaterialService->create(
            $request,
            auth()->id()
        );

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
        $pivot = $this->getUserLearningMaterialPivot(
            $learningMaterial,
            $user->id
        );

        $started = $this->hasStarted($pivot);
        $ended = $this->hasEnded($pivot);

        return Inertia::render('learningMaterial/Show', [
            'learningMaterial' => $this->prepareLearningMaterialForShow(
                $learningMaterial,
                $started,
                $ended
            ),
            'from' => $request->query('from', 'index'),
            'userStatus' => $this->getUserStatusArray($pivot),
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

        $learningMaterial = $this->learningMaterialService->update(
            $request,
            $learningMaterial,
            auth()->id()
        );

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

        return redirect()
            ->route('learningMaterials.show', $learningMaterial->slug);
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

        return redirect()
            ->route('learningMaterials.show', $learningMaterial->slug);
    }

    /**
     * Get the count of archived (soft deleted) learning materials.
     *
     * @return int
     */
    private function getArchivedCount(): int
    {
        return LearningMaterial::onlyTrashed()->count();
    }

    /**
     * Retrieve paginated learning materials with related providers
     * and departments, including a count of users with activity status.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getPaginatedLearningMaterials()
    {
        return LearningMaterial::with(['learningProvider', 'department'])
            ->withCount([
                'users as has_activity' => function ($query) {
                    $query->whereIn('learning_material_user.status', [
                        LearningMaterialUser::STATUS_STARTED,
                        LearningMaterialUser::STATUS_COMPLETED,
                    ]);
                },
            ])
            ->paginate(10);
    }

    /**
     * Retrieve the authenticated user with their role.
     *
     * @return \App\Models\User|null
     */
    private function getAuthUserWithRole()
    {
        return User::where('id', auth()->id())
            ->with('role:id,name')
            ->first();
    }

    /**
     * Get the pivot table record linking the given user and learning material.
     *
     * @param LearningMaterial $learningMaterial
     * @param int $userId
     *
     * @return \Illuminate\Database\Eloquent\Relations\Pivot|null
     */
    private function getUserLearningMaterialPivot(
        LearningMaterial $learningMaterial,
        int $userId
    ) {
        return $learningMaterial->users()
            ->where('user_id', $userId)
            ->first()?->pivot;
    }

    /**
     * Determine if the learning material has been started by the user.
     *
     * @param mixed $pivot
     *
     * @return bool
     */
    private function hasStarted($pivot): bool
    {
        return $pivot &&
            (int) $pivot->status !== LearningMaterialUser::STATUS_NOT_STARTED;
    }

    /**
     * Determine if the learning material has been completed by the user.
     *
     * @param mixed $pivot
     *
     * @return bool
     */
    private function hasEnded($pivot): bool
    {
        return $pivot &&
            (int) $pivot->status === LearningMaterialUser::STATUS_COMPLETED;
    }

    /**
     * Prepare the learning material data for the show view,
     * including started and ended flags.
     *
     * @param LearningMaterial $learningMaterial
     * @param bool $started
     * @param bool $ended
     *
     * @return array
     */
    private function prepareLearningMaterialForShow(
        LearningMaterial $learningMaterial,
        bool $started,
        bool $ended
    ): array {
        return array_merge(
            $learningMaterial->load(
                ['learningProvider', 'department']
            )->toArray(),
            [
                'started' => $started,
                'ended' => $ended,
            ]
        );
    }

    /**
     * Get the user's status array from the pivot, or null if none.
     *
     * @param mixed $pivot
     *
     * @return array|null
     */
    private function getUserStatusArray($pivot): ?array
    {
        if (! $pivot) {
            return null;
        }

        return [
            'status' => $pivot->status,
            'completed_at' => $pivot->completed_at,
        ];
    }
}
