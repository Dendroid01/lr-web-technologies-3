<?php

use App\Http\Controllers\FormPageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\TestResultsController;
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

Route::get('/guest-book/import', [GuestBookController::class, 'importPage'])->name('guest-book.import');
Route::post('/guest-book/import', [GuestBookController::class, 'import'])->name('guest-book.import.store');
Route::get('/guest-book', [GuestBookController::class, 'index'])->name('guest-book.index');
Route::post('/guest-book', [GuestBookController::class, 'store'])->name('guest-book.store');

Route::get('/test/results', [TestResultsController::class, 'index'])->name('test.results');
