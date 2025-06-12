<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogLikeRequest;
use App\Models\Blog;
use App\Models\BlogLike;
use App\Policies\BlogLikePolicy;
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
     * Store a newly created BlogLike resource.
     *
     * @param StoreBlogLikeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlogLikeRequest $request)
    {
        $blog = Blog::findOrFail($request->input('blog_id'));
        $user = $request->user();

        $this->authorizeLike($user, $blog);

        $blogLike = $this->createBlogLike($user, $blog);
        $this->logger->like($blogLike, $user->id);

        return redirect()->route('blogs.show', $blog)
            ->with('success', 'Blog liked successfully.');
    }

    /**
     * Remove (unlike) the specified BlogLike resource.
     *
     * @param BlogLike $blogLike
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BlogLike $blogLike)
    {
        $user = Auth::user();

        $this->authorizeUnlike($user, $blogLike->blog);

        $this->deleteBlogLike($blogLike, $user);

        // Redirect back with success message
        return redirect()->route('blogs.index')
            ->with('success', 'Blog unliked successfully.');
    }

    /**
     * Toggle like/unlike status on a blog.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Blog $blog)
    {
        $user = Auth::user();

        $existing = BlogLike::where('blog_id', $blog->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            $this->unlikeBlog($existing, $user, $blog);
        } else {
            $this->likeBlog($user, $blog);
        }

        return back()->with('success', 'Blog like status updated.');
    }

    /**
     * Private helper to check authorization to like a blog.
     *
     * @param $user
     * @param Blog $blog
     *
     * @return void
     */
    private function authorizeLike($user, Blog $blog): void
    {
        $policy = new BlogLikePolicy();

        if (! $policy->like($user, $blog)) {
            abort(403, 'You have already liked this blog.');
        }
    }

    /**
     * Private helper to check authorization to unlike a blog.
     *
     * @param $user
     * @param Blog $blog
     *
     * @return void
     */
    private function authorizeUnlike($user, Blog $blog): void
    {
        $policy = new BlogLikePolicy();

        if (! $policy->unlike($user, $blog)) {
            abort(403, 'You have not liked this blog.');
        }
    }

    /**
     * Private helper to create a new BlogLike record.
     *
     * @param $user
     * @param Blog $blog
     *
     * @return BlogLike
     */
    private function createBlogLike($user, Blog $blog): BlogLike
    {
        return BlogLike::create([
            'blog_id' => $blog->id,
            'user_id' => $user->id,
            'created_by' => $user->id,
            'created_at' => now(),
        ]);
    }

    /**
     * Private helper to delete (soft-delete) a BlogLike record.
     *
     * @param BlogLike $blogLike
     * @param $user
     *
     * @return void
     */
    private function deleteBlogLike(BlogLike $blogLike, $user): void
    {
        $blogLike->update([
            'deleted_by' => $user->id,
            'deleted_at' => now(),
        ]);

        $blogLike->delete();

        $this->logger->unlike($blogLike, $user->id);
    }

    /**
     * Private helper to unlike blog inside toggle method.
     *
     * @param BlogLike $blogLike
     * @param $user
     * @param Blog $blog
     *
     * @return void
     */
    private function unlikeBlog(BlogLike $blogLike, $user, Blog $blog): void
    {
        $this->authorizeUnlike($user, $blog);

        $this->deleteBlogLike($blogLike, $user);
    }

    /**
     * Private helper to like blog inside toggle method.
     *
     * @param $user
     * @param Blog $blog
     *
     * @return void
     */
    private function likeBlog($user, Blog $blog): void
    {
        $this->authorizeLike($user, $blog);

        $blogLike = $this->createBlogLike($user, $blog);

        $this->logger->like($blogLike, $user->id);
    }
}
