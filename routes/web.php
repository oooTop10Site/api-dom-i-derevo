<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(\App\Http\Controllers\Web\AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'index')->name('auth.index');
        Route::post('/login', 'login')->name('auth.login');
    });

    Route::middleware('auth:web')->get('/logout', 'logout')->name('auth.logout');
});

// Route::middleware('auth:web')->group(function () {
    Route::resource('user', \App\Http\Controllers\Web\UserController::class)->except(['show']);
    Route::resource('review', \App\Http\Controllers\Web\ReviewController::class)->except(['show']);
    Route::resource('feedback', \App\Http\Controllers\Web\FeedbackController::class)->except(['show']);

    Route::prefix('blog')->group(function () {
        Route::resource('category', \App\Http\Controllers\Web\Blog\CategoryController::class, ['as' => 'blog'])->except(['show']);
        Route::resource('article', \App\Http\Controllers\Web\Blog\ArticleController::class, ['as' => 'blog'])->except(['show']);
    })->name('blog');

    Route::prefix('service')->group(function () {
        Route::resource('category', \App\Http\Controllers\Web\Service\CategoryController::class, ['as' => 'service'])->except(['show']);
        Route::resource('example', \App\Http\Controllers\Web\Service\ExampleController::class, ['as' => 'service'])->except(['show']);
    })->name('service');

    Route::resource('service', \App\Http\Controllers\Web\Service\ServiceController::class)->except(['show']);

    Route::controller(\App\Http\Controllers\Web\MainController::class)->group(function () {
        Route::get('/', 'edit')->name('main.edit');
        Route::put('/', 'update')->name('main.update');
    });
// });
