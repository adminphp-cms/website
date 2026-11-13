<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function show(string $slug): View
    {
        $page = Page::query()->published()->where('slug', $slug)->with('blocks')->firstOrFail();

        return view('pages.show', [
            'page' => $page,
            'parent' => $page->parent()->published()->first(),
            'children' => $page->children()->published()->get(),
        ]);
    }
}
