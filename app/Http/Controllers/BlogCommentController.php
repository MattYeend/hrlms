<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCommentRequest;
use App\Http\Requests\UpdateBlogCommentRequest;
use App\Models\BlogComment;
use App\Models\User;
use App\Services\BlogCommentLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogCommentController extends Controller
{
    protected BlogCommentLogger $logger;

    public function __construct(BlogCommentLogger $logger)
    {
        $this->authorizeResource(BlogComment::class, 'blogComment');
        $this->logger = $logger;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogComment $blogComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogComment $blogComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCommentRequest $request, BlogComment $blogComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogComment $blogComment)
    {
        //
    }
}
