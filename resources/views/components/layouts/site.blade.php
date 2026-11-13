{{-- Layout of the public site; SiteLayoutComposer adds the site name and the menu. --}}
@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ isset($title) ? $title.' · '.$siteName : $siteName }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-stone-50 text-stone-800 antialiased">
        <header class="border-b border-stone-200 bg-white">
            <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-4 px-4 py-5">
                <a href="{{ route('home') }}" class="text-lg font-semibold text-stone-900">{{ $siteName }}</a>

                <nav class="flex flex-wrap gap-x-5 gap-y-2 text-sm">
                    <a href="{{ route('articles.index') }}" @class(['hover:text-stone-950', 'font-semibold text-stone-950' => request()->routeIs('articles.*')])>Articles</a>
                    @foreach ($navigation as $item)
                        <a href="{{ route('pages.show', $item->slug) }}" @class(['hover:text-stone-950', 'font-semibold text-stone-950' => request()->is($item->slug)])>{{ $item->title }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-10">
            {{ $slot }}
        </main>

        <footer class="border-t border-stone-200 py-6 text-center text-sm text-stone-500">
            {{ $siteName }}@if ($tagline) — {{ $tagline }}@endif
        </footer>
    </body>
</html>
