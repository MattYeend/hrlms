<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogLikeRequest;
use App\Models\Blog;
use App\Models\BlogLike;
use App\Services\BlogLikeLogger;
use Illuminate\Support\Facades\Auth;

class BlogLikeController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * BlogLikeLogger instance.
     */
    protected BlogLikeLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param BlogLikeLogger $logger
     * An instance of the BlogLikeLogger used for logging
     * user-related activities
     */
    public function __construct(BlogLikeLogger $logger)
    {
        $this->authorizeResource(BlogLike::class, 'blogLike');
        $this->logger = $logger;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogLikeRequest $request)
    {
        $this->authorize('like', BlogLike::class);

        $blog = Blog::findOrFail($request->input('blog_id'));
        $user = $request->user();

        $data = [
            'blog_id' => $blog->id,
            'user_id' => $user->id,
            'created_by' => $user->id,
            'created_at' => now(),
        ];

        $blogLike = BlogLike::create($data);

        $this->logger->like($blogLike, $user->id);

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog liked successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogLike $blogLike)
    {
        $this->authorize('unlike', $blogLike);

        $blogLike->update([
            'deleted_by' => Auth::id(),
            'deleted_at' => now(),
        ]);
        $blogLike->delete();

        $this->logger->unlike($blogLike, Auth::id());

        return redirect()->route('blogs.index')
            ->with('success', 'Blog unliked successfully.');
    }
}
