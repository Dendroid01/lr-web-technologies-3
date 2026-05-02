<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;

class StatisticsController extends Controller
{
    public function index()
    {
        $visits = PageVisit::orderByDesc('visited_at')->paginate(20);
        return view('admin.visits', compact('visits'));
    }
}
