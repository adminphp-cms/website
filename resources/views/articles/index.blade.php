<x-layouts.site title="Articles">
    <h1 class="mb-8 text-4xl font-bold text-stone-900">Articles</h1>

    <div class="grid gap-6 md:grid-cols-3">
        @forelse ($articles as $article)
            <x-article-card :article="$article" />
        @empty
            <p class="text-stone-500">Aucun article pour le moment.</p>
        @endforelse
    </div>

    <div class="mt-10">{{ $articles->links() }}</div>
</x-layouts.site>
