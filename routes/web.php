<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Last: any other one-segment address is a page, except the admin.
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '(?!'.preg_quote(config('adminphp.path'), '/').'$)[a-z0-9-]+')
    ->name('pages.show');
