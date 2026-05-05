<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use App\Services\BlogPostService;
use Illuminate\Http\JsonResponse;

class BlogEditorController extends Controller
{
    public function __construct(
        private readonly BlogPostService $blogPostService
    ) {}

    public function editor()
    {
        $posts = BlogPost::orderByDesc('created_at')->paginate(5);
        return view('blog.editor', compact('posts'));
    }

    public function store(BlogPostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->blogPostService->create(
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.blog.editor')
            ->with('success', true);
    }

    public function edit(BlogPost $post): JsonResponse
    {
        return response()->json([
            'id'      => $post->id,
            'title'   => $post->title,
            'message' => $post->message,
        ]);
    }

    public function update(BlogPostRequest $request, BlogPost $post): JsonResponse
    {
        $this->blogPostService->update(
            $post,
            $request->validated(),
            $request->file('image')
        );

        return response()->json([
            'success' => true,
            'post'    => [
                'id'         => $post->id,
                'title'      => $post->title,
                'message'    => $post->message,
                'author'     => $post->author,
                'created_at' => $post->created_at->format('d.m.Y H:i'),
            ]
        ]);
    }
}
