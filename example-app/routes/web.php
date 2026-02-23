<?php

use App\Http\Controllers\FormPageController;
use App\Http\Controllers\PhotoController;
use App\Models\Interest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/interests', function () {
    $categories = Interest::getAllCategories();
    return view('interests', compact('categories'));
})->name('interests');

Route::get('/study', function () {
    return view('study');
})->name('study');

Route::get('/gallery', [PhotoController::class, 'index'])->name('gallery');
Route::get('/gallery/photo/{id}', [PhotoController::class, 'show'])->name('gallery.photo');

Route::get('/contacts', [FormPageController::class, 'showContacts'])->name('contacts');
Route::post('/contacts', [FormPageController::class, 'submitContacts'])->name('contacts.submit');

Route::get('/test', [FormPageController::class, 'showTest'])->name('test');
Route::post('/test', [FormPageController::class, 'submitTest'])->name('test.submit');

Route::get('/history', function () {
    return view('history');
})->name('history');
