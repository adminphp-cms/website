@props(['article'])

<article class="overflow-hidden rounded-xl border border-stone-200 bg-white">
    <a href="{{ route('articles.show', $article->slug) }}" class="block">
        @if ($article->coverMedia)
            <x-adminphp::image :media="$article->coverMedia" sizes="(min-width: 768px) 320px, 100vw" class="aspect-[16/10] w-full object-cover" />
        @endif
        <div class="space-y-2 p-5">
            <p class="text-xs uppercase tracking-wide text-stone-500">{{ $article->published_at?->translatedFormat('j F Y') }}</p>
            <h2 class="text-lg font-semibold text-stone-900">{{ $article->title }}</h2>
            @if ($article->lead)
                <p class="line-clamp-3 text-sm text-stone-600">{{ $article->lead }}</p>
            @endif
        </div>
    </a>
</article>
