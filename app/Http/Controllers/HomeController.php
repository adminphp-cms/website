<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Page;
use Gmarineau\AdminPhp\AdminPhp;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(AdminPhp $adminPhp): View
    {
        $homepageId = $adminPhp->setting('homepage');

        return view('home', [
            'page' => $homepageId ? Page::query()->published()->with('blocks')->find($homepageId) : null,
            'articles' => Article::query()->published()->with('coverAsset')->latest('published_at')->limit(3)->get(),
        ]);
    }
}
