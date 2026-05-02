<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;

class BlogEditorController extends Controller
{
    public function editor()
    {
        $posts = BlogPost::orderByDesc('created_at')->paginate(5);
        return view('blog.editor', compact('posts'));
    }

    public function store(BlogPostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($data);

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
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'post'    => [
                'id'        => $post->id,
                'title'     => $post->title,
                'message'   => $post->message,
                'author'    => $post->author,
                'created_at'=> $post->created_at->format('d.m.Y H:i'),
            ]
        ]);
    }
}
