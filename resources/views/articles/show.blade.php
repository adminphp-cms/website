{{-- Also the preview of the admin: $article may be unsaved there. --}}
<x-layouts.site :title="$article->title">
    <article class="mx-auto max-w-3xl">
        <a href="{{ route('articles.index') }}" class="text-sm text-stone-500 hover:text-stone-900">← Articles</a>

        <header class="mt-4 mb-8 space-y-4">
            @if ($article->published_at)
                <p class="text-sm uppercase tracking-wide text-stone-500">{{ $article->published_at->translatedFormat('j F Y') }}</p>
            @endif
            <h1 class="text-4xl font-bold text-stone-900">{{ $article->title }}</h1>
            @if ($article->lead)
                <p class="text-xl text-stone-600">{{ $article->lead }}</p>
            @endif
        </header>

        @if ($article->coverMedia)
            <x-adminphp::image :media="$article->coverMedia" sizes="(min-width: 768px) 768px, 100vw" loading="eager" class="mb-10 w-full rounded-xl" />
        @endif

        <x-blocks :blocks="$article->blocks" />
    </article>
</x-layouts.site>
