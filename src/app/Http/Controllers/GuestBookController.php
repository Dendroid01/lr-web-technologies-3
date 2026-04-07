<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestBookRequest;
use App\Models\GuestBookMessage;

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
}
