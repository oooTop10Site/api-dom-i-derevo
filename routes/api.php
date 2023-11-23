<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('main')->controller(\App\Http\Controllers\Api\MainController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/show/{code}', 'show');
});

Route::prefix('feedback')->controller(\App\Http\Controllers\Api\FeedbackController::class)->group(function () {
    Route::post('/store', 'store')->name('api.feedback.store');
});

Route::prefix('review')->controller(\App\Http\Controllers\Api\ReviewController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/show/{review}', 'show');
    Route::post('/store', 'store')->name('api.review.store');
});

Route::prefix('blog')->group(function () {
    Route::prefix('category')->controller(\App\Http\Controllers\Api\Blog\CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{seo_keyword}', 'show');
    });

    Route::prefix('article')->controller(\App\Http\Controllers\Api\Blog\ArticleController::class)->group(function () {
        Route::get('/show/{seo_keyword}', 'show');
    });
});

Route::prefix('service')->group(function () {
    Route::prefix('category')->controller(\App\Http\Controllers\Api\Service\CategoryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/show/{seo_keyword}', 'show');
    });

    Route::controller(\App\Http\Controllers\Api\Service\ServiceController::class)->group(function () {
        Route::get('/show/{seo_keyword}', 'show');
    });
});
