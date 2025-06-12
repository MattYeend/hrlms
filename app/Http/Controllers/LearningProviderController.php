<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLearningProviderRequest;
use App\Http\Requests\UpdateLearningProviderRequest;
use App\Models\BusinessType;
use App\Models\LearningProvider;
use App\Models\User;
use App\Services\LearningProviderLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LearningProviderController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * LearningProviderLogger instance.
     */
    protected LearningProviderLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param LearningProviderLogger $logger
     * An instance of the LearningProviderLogger used for logging
     * user-related activities
     */
    public function __construct(LearningProviderLogger $logger)
    {
        $this->authorizeResource(LearningProvider::class, 'learningProvider');
        $this->logger = $logger;
    }

    /**
     * Display a paginated list of active learning providers.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny', LearningProvider::class);

        $this->logger->index(auth()->id());

        $archivedCount = LearningProvider::onlyTrashed()->count();

        $learningProvider = LearningProvider::with('businessType')
            ->paginate(10);

        return Inertia::render('learningProvider/Index', [
            'learningProviders' => $learningProvider,
            'authUser' => User::where('id', auth()->id())
                ->with('role:id,name')
                ->first(),
            'hasArchivedLearningProviders' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form to create a new learning provider.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', LearningProvider::class);

        $learningProviders = LearningProvider::with('businessType')->get();
        $businessTypes = BusinessType::select('id', 'name')->get();

        return Inertia::render('learningProvider/Create', [
            'learningProviders' => $learningProviders,
            'businessTypes' => $businessTypes,
        ]);
    }

    /**
     * Store a new learning provider in the database.
     *
     * @param StoreLearningProviderRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreLearningProviderRequest $request)
    {
        $this->authorize('create', LearningProvider::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['created_by'] = auth()->id();

        $learningProvider = LearningProvider::create($data);

        $this->logger->create($learningProvider, auth()->id());

        return redirect()->route('learningProviders.show', $learningProvider)
            ->with('success', 'Learning Provider created successfully.');
    }

    /**
     * Display the specified learning provider.
     *
     * @param LearningProvider $learningProvider
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function show(LearningProvider $learningProvider, Request $request)
    {
        $this->authorize('view', $learningProvider);

        $this->logger->show($learningProvider, auth()->id());

        return Inertia::render('learningProvider/Show', [
            'learningProvider' => $learningProvider->load('businessType'),
            'from' => $request->query('from', 'index'),
        ]);
    }

    /**
     * Show the form for editing a learning provider.
     *
     * @param LearningProvider $learningProvider
     *
     * @return \Inertia\Response
     */
    public function edit(LearningProvider $learningProvider)
    {
        $this->authorize('update', $learningProvider);

        return Inertia::render('learningProvider/Edit', [
            'learningProvider' => $learningProvider,
            'businessTypes' => BusinessType::select('id', 'name')->get(),
        ]);
    }

    /**
     * Update the specified learning provider.
     *
     * @param UpdateLearningProviderRequest $request
     * @param LearningProvider $learningProvider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateLearningProviderRequest $request,
        LearningProvider $learningProvider
    ) {
        $this->authorize('update', $learningProvider);

        $data = $request->validated();

        $learningProvider->update(array_merge(
            $data,
            [
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]
        ));

        $this->logger->update($learningProvider, auth()->id());

        return redirect()->route('learningProviders.show', $learningProvider)
            ->with('success', 'Learning Provider updated successfully.');
    }

    /**
     * Soft-delete (archive) the learning provider.
     *
     * @param LearningProvider $learningProvider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LearningProvider $learningProvider)
    {
        $this->authorize('delete', $learningProvider);

        $learningProvider->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $learningProvider->delete();

        $this->logger->delete($learningProvider, auth()->id());

        return redirect()->route('learningProviders.index')
            ->with('success', 'Learning Provider deleted successfully.');
    }

    /**
     * Restore a previously deleted learning provider.
     *
     * @param LearningProvider $learningProvider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(LearningProvider $learningProvider)
    {
        $this->authorize('restore', $learningProvider);

        $learningProvider->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $learningProvider->restore();

        $this->logger->restore($learningProvider, auth()->id());

        return redirect()->route(
            'learningProviders.show',
            $learningProvider,
        )->with('success', 'Learning Provider restored.');
    }

    /**
     * Display a list of archived learning providers.
     *
     * @return \Inertia\Response
     */
    public function archived()
    {
        $this->authorize('viewArchived', LearningProvider::class);

        $this->logger->archived(auth()->id());

        $learningProvider = LearningProvider::onlyTrashed()
            ->with('businessType')
            ->paginate(10);

        $authUser = User::where('id', auth()->id())
            ->with('role:id,name')
            ->first();

        return Inertia::render('learningProvider/Archived', [
            'learningProviders' => $learningProvider,
            'authUser' => $authUser,
        ]);
    }
}
