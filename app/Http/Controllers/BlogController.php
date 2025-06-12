<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Services\BlogLogger;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * BlogLogger instance.
     */
    protected BlogLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param BlogLogger $logger
     * An instance of the BlogLogger used for logging
     * user-related activities
     */
    public function __construct(BlogLogger $logger)
    {
        $this->authorizeResource(Blog::class, 'blog');
        $this->logger = $logger;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Blog::class);

        $this->logger->index(auth()->id());

        $query = $this->buildBlogQuery(request('status'));

        $archivedCount = Blog::onlyTrashed()->count();

        return Inertia::render('blogs/Index', [
            'blogs' => $query->paginate(10),
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
            'hasArchivedJobs' => $archivedCount > 0,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Blog::class);

        return Inertia::render('blogs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $this->authorize('create', Blog::class);

        $data = $request->validated();

        $blog = Blog::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
            'created_by' => auth()->id(),
            'created_at' => now(),
        ]);

        $this->logger->create($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $this->authorize('view', $blog);

        if (! request()->header('X-Inertia-Partial-Component')) {
            $this->logger->show($blog, auth()->id());
        }

        $blog->load(['comments.user', 'createdBy', 'approvedBy']);
        $blog->loadCount('likes');

        $blogData = $blog->toArray();

        $blogData['approved_by'] =
            $blog->approvedBy ? ['name' => $blog->approvedBy->name] : null;

        $blogData['created_by'] = ['name' => $blog->createdBy->name];

        return Inertia::render('blogs/Show', [
            'blog' => $blogData,
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
            'from' => request('from', 'index'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);

        return Inertia::render('blogs/Edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $data = $request->validated();

        $blog->update([
            'title' => $data['title'] ?? $blog->title,
            'slug' => Str::slug($data['title'] ?? $blog->title),
            'content' => $data['content'] ?? $blog->content,
            'updated_by' => auth()->id(),
            'updated_at' => now(),
        ]);

        $this->logger->update($blog, auth()->id());

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $blog->update([
            'deleted_by' => auth()->id(),
            'deleted_at' => now(),
            'is_archived' => true,
        ]);
        $blog->delete();

        $this->logger->delete($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Blog $blog)
    {
        $this->authorize('restore', $blog);

        $blog->update([
            'deleted_at' => null,
            'deleted_by' => null,
            'is_archived' => false,
            'restored_at' => now(),
            'restored_by' => auth()->id(),
        ]);
        $blog->restore();

        $this->logger->restore($blog, auth()->id());

        return redirect()->route(
            'blogs.show',
            $blog,
        )->with('success', 'Blog restored.');
    }

    /**
     * Display listed archived of the resource.
     */
    public function archived()
    {
        $this->authorize('viewArchived', Blog::class);

        $this->logger->archived(auth()->id());

        return Inertia::render('blogs/Archived', [
            'blogs' => Blog::onlyTrashed()->with([
                'approvedBy:id,name',
            ])->paginate(10),
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
        ]);
    }

    /**
     * Display listed denied of the resource.
     */
    public function denied()
    {
        $this->authorize('viewDenied', Blog::class);

        $this->logger->viewDenied(auth()->id());

        return Inertia::render('blogs/Denied', [
            'blogs' => Blog::with([
                'deniedBy:id,name',
            ])
                ->where('denied', true)
                ->where('approved', false)
                ->get(),
            'authUser' => [
                'id' => auth()->user()->id,
                'role' => [
                    'name' => auth()->user()->role->name,
                ],
            ],
        ]);
    }

    /**
     * Approve specified resource.
     */
    public function approve(Blog $blog)
    {
        $this->authorize('approve', $blog);

        $blog->approved = true;
        $blog->approved_by = auth()->id();
        $blog->approved_at = now();
        $blog->denied = false;
        $blog->denied_by = null;
        $blog->denied_at = null;
        $blog->save();

        $this->logger->approved($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog approved successfully.');
    }

    /**
     * Deny specified resource.
     */
    public function deny(Blog $blog)
    {
        $this->authorize('approve', $blog);

        $blog->approved = false;
        $blog->approved_by = null;
        $blog->approved_at = null;
        $blog->denied = true;
        $blog->denied_by = auth()->id();
        $blog->denied_at = now();
        $blog->save();

        $this->logger->denied($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog denied.');
    }

    /**
     * Build the base query for retrieving blog posts based on approval status.
     *
     * This method filters out denied blogs and applies additional filters
     * based on the provided status:
     * - 'pending': blogs that are not approved
     * - 'approved': blogs that are approved
     *
     * @param string|null $status The status filter to apply
     * ('pending', 'approved', or null).
     *
     * @return \Illuminate\Database\Eloquent\Builder The constructed query
     * builder instance.
     */
    private function buildBlogQuery(?string $status)
    {
        $query = Blog::with('approvedBy:id,name')
            ->where('denied', false);

        if ($status === 'pending') {
            $query->where('approved', false);
        } elseif ($status === 'approved') {
            $query->where('approved', true);
        }

        return $query;
    }
}
