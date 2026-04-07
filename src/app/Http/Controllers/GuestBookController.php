<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestBookRequest;
use App\Models\GuestBookMessage;
use App\Http\Requests\GuestBookImportRequest;
use App\Services\GuestBookImportService;

class GuestBookController extends Controller
{
    public function index()
    {
        $messages = GuestBookMessage::orderByDesc('created_at')->get();
        return view('guest-book', compact('messages'));
    }

    public function store(GuestBookRequest $request)
    {
        GuestBookMessage::create([
            ...$request->validated(),
            'created_at' => now(),
        ]);

        return redirect()->route('guest-book.index')
            ->with('success', 'Ваш отзыв успешно добавлен!');
    }

    public function importPage()
    {
        return view('guest-book-import');
    }
    public function import(GuestBookImportRequest $request, GuestBookImportService $importService)
    {
        $stats = $importService->import($request->file('file'));

        return redirect()->route('guest-book.index')
            ->with('success', "Импортировано: {$stats['imported']}, пропущено: {$stats['skipped']}");
    }
}


