<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\LearningProvider;
use App\Models\Quiz;
use App\Models\User;
use App\Services\QuizLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QuizController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * QuizLogger instance.
     */
    protected QuizLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param QuizLogger $logger
     * An instance of the QuizLogger used for logging
     * user-related activities
     */
    public function __construct(QuizLogger $logger)
    {
        $this->authorizeResource(Quiz::class, 'quiz');
        $this->logger = $logger;
    }

    /**
     * Display a paginated list of active learning providers.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Quiz::class);

        $this->logger->index(auth()->id());

        $archivedCount = Quiz::onlyTrashed()->count();

        $quiz = Quiz::with(['learningProvider', 'completedBy'])
            ->paginate(10);

        return Inertia::render('quizzes/Index', [
            'quizzes' => $quiz,
            'authUser' => User::where('id', auth()->id())
                ->with('role:id,name')
                ->first(),
            'hasArchivedQuizzes' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form to create a new learning provider.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Quiz::class);

        $quizzes = Quiz::get();
        $learningProviders = LearningProvider::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        return Inertia::render('quizzes/Create', [
            'quizzes' => $quizzes,
            'learningProviders' => $learningProviders,
            'users' => $users,
        ]);
    }

    /**
     * Store a new learning provider in the database.
     *
     * @param StoreLearningProviderRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreQuizRequest $request)
    {
        $this->authorize('create', Quiz::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();

        $quiz = Quiz::create($data);

        $this->logger->create($quiz, auth()->id());

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified learning provider.
     *
     * @param Quiz $quiz
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function show(Quiz $quiz, Request $request)
    {
        $this->authorize('view', $quiz);

        $this->logger->show($quiz, auth()->id());

        return Inertia::render('quizzes/Show', [
            'quiz' => $quiz->load('learningProvider'),
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
    public function edit(Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $learningProviders = LearningProvider::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        return Inertia::render('quizzes/Edit', [
            'quiz' => $quiz,
            'learningProviders' => $learningProviders,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified learning provider.
     *
     * @param UpdateQuizRequst $request
     * @param Quiz $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $data = $request->validated();

        $quiz->update(array_merge(
            $data,
            [
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]
        ));

        $this->logger->update($quiz, auth()->id());

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Soft-delete the the quiz.
     *
     * @param Quiz $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Quiz $quiz)
    {
        $this->authorize('delete', $quiz);

        $quiz->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $quiz->delete();

        $this->logger->delete($quiz, auth()->id());

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Restore a previously deleted quiz.
     *
     * @param Quiz $quiz
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Quiz $quiz)
    {
        $this->authorize('restore', $quiz);

        $quiz->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $quiz->restore();

        $this->logger->restore($quiz, auth()->id());

        return redirect()->route(
            'quizzes.show',
            $quiz,
        )->with('success', 'Quiz Provider restored.');
    }

    /**
     * Display a list of archived learning providers.
     *
     * @return \Inertia\Response
     */
    public function archived()
    {
        $this->authorize('viewArchived', Quiz::class);

        $this->logger->archived(auth()->id());

        $quiz = Quiz::onlyTrashed()
            ->with(['learningProvider', 'completedBy'])
            ->paginate(10);

        $authUser = User::where('id', auth()->id())
            ->with('role:id,name')
            ->first();

        return Inertia::render('quizzes/Archived', [
            'quizzes' => $quiz,
            'authUser' => $authUser,
        ]);
    }

    /**
     * Mark the quiz as completed by the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Quiz $quiz
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function complete(Request $request, Quiz $quiz)
    {
        $data = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'passed' => 'required|boolean',
        ]);

        $user = auth()->user();
        $score = $data['score'];
        $passed = $score >= $quiz->pass_percentage;

        if ($this->hasAlreadyCompleted($quiz, $user->id)) {
            return response()->json([
                'message' => 'You have already completed this quiz.',
            ], 409);
        }

        $this->markAsCompleted($quiz, $user->id, $score, $passed);

        return response()->json(['message' => 'Quiz marked as completed.']);
    }

    /**
     * Check if the user has already completed the given quiz.
     *
     * @param \App\Models\Quiz $quiz The quiz to check.
     * @param int $userId The ID of the user.
     *
     * @return bool True if the user has already completed the quiz,
     * false otherwise.
     */
    private function hasAlreadyCompleted(Quiz $quiz, int $userId): bool
    {
        return $quiz->completedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Mark the quiz as completed by the user, record score and pass status,
     * and log the completion event.
     *
     * @param \App\Models\Quiz $quiz The quiz being completed.
     * @param int $userId The ID of the user completing the quiz.
     * @param float $score The score obtained by the user.
     * @param bool $passed Whether the user passed the quiz.
     *
     * @return void
     */
    private function markAsCompleted(
        Quiz $quiz,
        int $userId,
        float $score,
        bool $passed
    ): void {
        $quiz->completedBy()->syncWithoutDetaching([
            $userId => [
                'score' => $score,
                'passed' => $passed,
                'created_at' => now(),
            ],
        ]);

        $this->logger->complete($quiz, $userId, $score, $passed);
    }
}
