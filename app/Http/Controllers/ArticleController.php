<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('articles.index', [
            'articles' => Article::query()->published()->with('coverMedia')->latest('published_at')->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $article = Article::query()->published()->where('slug', $slug)->with(['blocks', 'coverMedia'])->firstOrFail();

        return view('articles.show', ['article' => $article]);
    }
}
