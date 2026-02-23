<?php

use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/interests', function () {
    return view('interests');
})->name('interests');

Route::get('/study', function () {
    return view('study');
})->name('study');

Route::get('/gallery', [PhotoController::class, 'index'])->name('gallery');
Route::get('/gallery/photo/{id}', [PhotoController::class, 'show'])->name('gallery.photo');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/history', function () {
    return view('history');
})->name('history');
