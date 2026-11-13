<x-layouts.site>
    @if ($page)
        <h1 class="mb-8 text-4xl font-bold text-stone-900">{{ $page->title }}</h1>
        <x-blocks :blocks="$page->blocks" class="max-w-3xl" />
    @endif

    @if ($articles->isNotEmpty())
        <section class="mt-16">
            <div class="mb-6 flex items-baseline justify-between">
                <h2 class="text-2xl font-semibold text-stone-900">Derniers articles</h2>
                <a href="{{ route('articles.index') }}" class="text-sm underline">Tous les articles</a>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.site>
