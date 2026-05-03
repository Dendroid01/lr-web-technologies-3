<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('index');
    }

    public function about(): View
    {
        return view('about');
    }

    public function interests(): View
    {
        $categories = Interest::getAllCategories();

        return view('interests', compact('categories'));
    }

    public function study(): View
    {
        return view('study');
    }

    public function history(): View
    {
        return view('history');
    }
}
