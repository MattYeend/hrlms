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
     * Declare a protected property to hold the
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
     * @return void
     */
    public function store(StoreBlogLikeRequest $request): void
    {
        $blog = Blog::findOrFail($request->input('blog_id'));
        $user = $request->user();

        $this->authorizeAction('like', $user, $blog);

        $blogLike = $this->createBlogLike($user, $blog);
        $this->logger->like($blogLike, $user->id);
    }

    /**
     * Remove (unlike) the specified BlogLike resource.
     *
     * @param BlogLike $blogLike
     *
     * @return void
     */
    public function destroy(BlogLike $blogLike): void
    {
        $user = Auth::user();

        $this->authorizeAction('unlike', $user, $blogLike->blog);
        $this->deleteBlogLike($blogLike, $user);
    }

    /**
     * Toggle like/unlike status on a blog.
     *
     * @param Blog $blog
     *
     * @return void
     */
    public function toggle(Blog $blog): void
    {
        $this->canLikeBlog($blog);

        $user = Auth::user();
        $existing = $this->findUserLike($blog->id, $user->id);

        if ($existing) {
            $this->authorizeAction('unlike', $user, $blog);
            $this->deleteBlogLike($existing, $user);
            return;
        }

        $this->authorizeAction('like', $user, $blog);
        $blogLike = $this->createBlogLike($user, $blog);
        $this->logger->like($blogLike, $user->id);
    }

    /**
     * Consolidated authorization helper.
     *
     * @param string $action
     * @param mixed $user
     * @param Blog $blog
     *
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function authorizeAction(string $action, $user, Blog $blog): void
    {
        $policy = new BlogLikePolicy();

        if (! $policy->{$action}($user, $blog)) {
            $messages = [
                'like' => 'You have already liked this blog.',
                'unlike' => 'You have not liked this blog.',
            ];
            abort(403, $messages[$action] ?? 'Unauthorized action.');
        }
    }

    /**
     * Private helper to create a new BlogLike record.
     *
     * @param mixed $user
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
     * @param mixed $user
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
     * Private helper to see if a blog can be liked.
     *
     * @param Blog $blog
     *
     * @return void
     */
    private function canLikeBlog(Blog $blog): void
    {
        if (! $this->isBlogLikeable($blog)) {
            abort(403, 'Cannot like an unapproved or archived blog.');
        }
    }

    /**
     * Private helper to check if blog is likeable.
     *
     * @param Blog $blog
     *
     * @return bool
     */
    private function isBlogLikeable(Blog $blog): bool
    {
        return $blog->approved && ! $blog->denied;
    }

    /**
     * Private helper to find an existing like by user and blog.
     *
     * @param int $blogId
     * @param int $userId
     *
     * @return BlogLike|null
     */
    private function findUserLike(int $blogId, int $userId): ?BlogLike
    {
        return BlogLike::where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();
    }
}
