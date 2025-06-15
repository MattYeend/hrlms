<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCommentRequest;
use App\Http\Requests\UpdateBlogCommentRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Services\BlogCommentLogger;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    /**
     * Declare a protected propert to hold the
     * BlogCommentLogger instance.
     */
    protected BlogCommentLogger $logger;

    /**
     * Constructor for the controller
     *
     * @param BlogCommentLogger $logger
     * An instance of the BlogCommentLogger used for logging
     * user-related activities
     */
    public function __construct(BlogCommentLogger $logger)
    {
        $this->authorizeResource(BlogComment::class, 'blogComment');
        $this->logger = $logger;
    }

    /**
     * Store a newly created BlogComment resource in storage.
     *
     * @param StoreBlogCommentRequest $request
     * Validated request instance containing blog_id and comment content.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBlogCommentRequest $request)
    {
        $blog = Blog::findOrFail($request->input('blog_id'));

        if (! $blog->approved || $blog->is_archived || $blog->denied) {
            abort(403, 'Cannot comment on this blog.');
        }

        $user = $request->user();

        $comment = BlogComment::create([
            'blog_id' => $blog->id,
            'user_id' => $user->id,
            'comment' => $request->input('comment'),
            'created_by' => $user->id,
            'created_at' => now(),
        ]);

        $this->logger->create($comment, $user->id);

        return redirect()->route('blogs.show', $blog->slug)
            ->with('success', 'Comment posted successfully.');
    }

    /**
     * Update the specified BlogComment resource in storage.
     *
     * @param UpdateBlogCommentRequest $request
     * Validated request instance containing updated comment text.
     * @param BlogComment $blogComment
     * The blog comment model instance to be updated.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        UpdateBlogCommentRequest $request,
        BlogComment $blogComment
    ) {
        $user = $request->user();

        $blogComment->update([
            'comment' => $request->input('comment'),
            'updated_by' => $user->id,
            'updated_at' => now(),
        ]);

        $this->logger->update($blogComment, $user->id);

        return redirect()->route('blogs.show', $blogComment->blog->slug)
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified BlogComment resource from storage.
     *
     * @param BlogComment $blogComment
     * The blog comment instance to be soft-deleted.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BlogComment $blogComment)
    {
        $blogComment->update([
            'deleted_by' => Auth::id(),
            'deleted_at' => now(),
        ]);

        $blogComment->delete();

        $this->logger->delete($blogComment, Auth::id());

        return redirect()->route('blogs.show', $blogComment->blog->slug)
            ->with('success', 'Comment deleted successfully.');
    }
}
