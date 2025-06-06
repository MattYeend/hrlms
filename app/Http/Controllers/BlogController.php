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
    protected BlogLogger $logger;

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

        $blogs = Blog::latest()->paginate(10);

        $archivedCount = Blog::onlyTrashed()->count();

        return Inertia::render('blogs/Index', [
            'blogs' => $blogs,
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

        $this->logger->show($blog, auth()->id());

        return Inertia::render('Blogs/Show', [
            'blog' => $blog,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);

        return Inertia::render('Blogs/Edit', [
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
            'delated_at' => now(),
            'is_archived' => true,
        ]);
        $blog->delete();

        $this->logger->delete($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

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
            'blogs.show'
        )->with('success', 'Blog restored.');
    }

    public function archived()
    {
        $this->authorize('viewArchived', Blog::class);

        $this->logger->archived(auth()->id());

        $blogs = Blog::latest()->paginate(10);

        return Inertia::render('blogs/Index', [
            'blogs' => $blogs,
        ]);
    }

    public function approve(Blog $blog)
    {
        $this->authorize('approve', $blog);

        $blog->approved = true;
        $blog->approved_by = auth()->id();
        $blog->approved_at = now();
        $blog->save();

        $this->logger->approved($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog approved successfully.');
    }

    public function deny(Blog $blog)
    {
        $this->authorize('approve', $blog);

        $blog->approved = false;
        $blog->approved_by = auth()->id();
        $blog->approved_at = now();
        $blog->save();

        $this->logger->denied($blog, auth()->id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog denied.');
    }
}
