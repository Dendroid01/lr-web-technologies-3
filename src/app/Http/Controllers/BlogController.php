<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Http\Requests\BlogImportRequest;
use App\Models\BlogPost;
use App\Services\BlogImportService;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::orderByDesc('created_at')->paginate(5);
        return view('blog.index', compact('posts'));
    }

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

        $data['created_at'] = now();

        BlogPost::create($data);

        return redirect()->route('blog.editor')
            ->with('success', 'Запись успешно добавлена!');
    }

    public function importPage()
    {
        return view('blog.import');
    }

    public function import(BlogImportRequest $request, BlogImportService $importService)
    {
        $stats = $importService->import($request->file('file'));

        return redirect()->route('blog.import')
            ->with('success', "Импортировано: {$stats['imported']}, пропущено: {$stats['skipped']}");
    }
}
