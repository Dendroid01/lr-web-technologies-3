<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogEditorController;
use App\Http\Controllers\BlogImportController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\FormPageController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\GuestBookImportController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TestResultsController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware([App\Http\Middleware\TrackVisitMiddleware::class])->group(function () {

    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/interests', [PageController::class, 'interests'])->name('interests');
    Route::get('/study', [PageController::class, 'study'])->name('study');

    Route::get('/gallery', [PhotoController::class, 'index'])->name('gallery');
    Route::get('/gallery/photo/{id}', [PhotoController::class, 'show'])->name('gallery.photo');

    Route::get('/contacts', [FormPageController::class, 'showContacts'])->name('contacts');
    Route::post('/contacts', [FormPageController::class, 'submitContacts'])->name('contacts.submit');

    Route::get('/test', [FormPageController::class, 'showTest'])->name('test');
    Route::post('/test', [FormPageController::class, 'submitTest'])->name('test.submit');

    Route::get('/history', [PageController::class, 'history'])->name('history');

    Route::get('/guest-book', [GuestBookController::class, 'index'])->name('guest-book.index');
    Route::post('/guest-book', [GuestBookController::class, 'store'])->name('guest-book.store');

    Route::get('/test/results', [TestResultsController::class, 'index'])
        ->middleware('auth')
        ->name('test.results');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/{post}/comments', [BlogCommentController::class, 'index'])->name('blog.comments.index');
        Route::get('/add-comment', [BlogCommentController::class, 'store'])->name('blog.comments.store'); // GET для JSONP
    });
});

Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
Route::get('/check-login', [UserAuthController::class, 'checkLogin'])->name('check.login');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/visits', [StatisticsController::class, 'index'])->name('visits');

        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/editor', [BlogEditorController::class, 'editor'])->name('editor');
            Route::post('/editor', [BlogEditorController::class, 'store'])->name('store');
            Route::get('/import', [BlogImportController::class, 'importPage'])->name('import');
            Route::post('/import', [BlogImportController::class, 'import'])->name('import.store');

            Route::get('/{post}/edit', [BlogEditorController::class, 'edit'])->name('blog.edit');
            Route::put('/{post}', [BlogEditorController::class, 'update'])->name('blog.update');
        });

        Route::get('/guest-book/import', [GuestBookImportController::class, 'importPage'])->name('guest-book.import');
        Route::post('/guest-book/import', [GuestBookImportController::class, 'import'])->name('guest-book.import.store');
    });
});
