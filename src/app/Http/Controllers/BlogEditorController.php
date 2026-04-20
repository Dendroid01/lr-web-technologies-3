<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Models\BlogPost;

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

        return redirect()->route('blog.editor')
            ->with('success', true);
    }
}
