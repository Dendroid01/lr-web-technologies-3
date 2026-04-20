<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestBookImportRequest;
use App\Services\GuestBookImportService;

class GuestBookImportController extends Controller
{
    public function importPage()
    {
        return view('guest-book-import');
    }

    public function import(GuestBookImportRequest $request, GuestBookImportService $importService)
    {
        $stats = $importService->import($request->file('file'));

        return redirect()->route('guest-book.index')
            ->with('import_stats', $stats);
    }
}
