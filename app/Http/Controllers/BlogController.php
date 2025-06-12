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
     * Display a listing of the blog resources.
     *
     * @return \Inertia\Response
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
     * Show the form for creating a new blog.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Blog::class);

        return Inertia::render('blogs/Create');
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param StoreBlogRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Display the specified blog resource.
     *
     * @param Blog $blog
     *
     * @return \Inertia\Response
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
     * Show the form for editing the specified blog.
     *
     * @param Blog $blog
     *
     * @return \Inertia\Response
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);

        return Inertia::render('blogs/Edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param UpdateBlogRequest $request
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Soft-delete the specified blog.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Restore a previously deleted blog.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Display a listing of archived blogs.
     *
     * @return \Inertia\Response
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
     * Display a listing of denied blogs.
     *
     * @return \Inertia\Response
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
     * Approve a blog post.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Deny a blog post.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * Build the query to retrieve blogs based on approval status.
     *
     * @param string|null $status
     * The status filter ('pending', 'approved', or null).
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
