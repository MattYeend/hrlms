<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCommentRequest;
use App\Http\Requests\UpdateBlogCommentRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\User;
use App\Services\BlogCommentLogger;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    protected BlogCommentLogger $logger;

    public function __construct(BlogCommentLogger $logger)
    {
        $this->authorizeResource(BlogComment::class, 'blogComment');
        $this->logger = $logger;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCommentRequest $request)
    {
        $blog = Blog::findOrFail($request->input('blog_id'));
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
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCommentRequest $request, BlogComment $blogComment)
    {
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
     * Remove the specified resource from storage.
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
