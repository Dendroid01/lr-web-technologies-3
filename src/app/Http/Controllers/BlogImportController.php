<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogImportRequest;
use App\Services\BlogImportService;

class BlogImportController extends Controller
{
    public function importPage()
    {
        return view('blog.import');
    }

    public function import(BlogImportRequest $request, BlogImportService $importService)
    {
        $stats = $importService->import($request->file('file'));

        return redirect()->route('blog.index')
            ->with('import_stats', $stats);
    }
}
