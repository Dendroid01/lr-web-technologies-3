<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogPostRequest;
use App\Http\Requests\BlogImportRequest;
use App\Models\BlogPost;

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

    public function import(BlogImportRequest $request)
    {
        $file     = $request->file('file');
        $imported = 0;
        $skipped  = 0;

        if (($handle = fopen($file->getPathname(), 'r')) !== false) {
            fgetcsv($handle, 1000, ',');

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                if (count($row) < 4) {
                    $skipped++;
                    continue;
                }

                [$title, $message, $author, $created_at] = array_map('trim', $row);

                $validator = \Validator::make([
                    'title'   => $title,
                    'message' => $message,
                    'author'  => $author,
                ], (new \App\Http\Requests\BlogPostRequest())->rules());

                if ($validator->fails()) {
                    $skipped++;
                    continue;
                }

                try {
                    $created_at = \Carbon\Carbon::parse($created_at);
                } catch (\Exception $e) {
                    $skipped++;
                    continue;
                }

                $exists = BlogPost::where('title', $title)
                    ->where('author', $author)
                    ->where('created_at', $created_at)
                    ->exists();

                if ($exists) {
                    $skipped++;
                    continue;
                }

                BlogPost::create([
                    'title'      => $title,
                    'message'    => $message,
                    'author'     => $author,
                    'created_at' => $created_at,
                    'image'      => null,
                ]);

                $imported++;
            }

            fclose($handle);
        }

        return redirect()->route('blog.import')
            ->with('success', "Импортировано: {$imported}, пропущено: {$skipped}");
    }
}
