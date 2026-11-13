{{-- Also the preview of the admin: $page may be unsaved there. --}}
<x-layouts.site :title="$page->title">
    <article class="mx-auto max-w-3xl">
        @if ($parent)
            <a href="{{ route('pages.show', $parent->slug) }}" class="text-sm text-stone-500 hover:text-stone-900">← {{ $parent->title }}</a>
        @endif

        <h1 class="mt-4 mb-8 text-4xl font-bold text-stone-900">{{ $page->title }}</h1>

        <x-blocks :blocks="$page->blocks" />

        @if ($children->isNotEmpty())
            <nav class="mt-12 grid gap-4 sm:grid-cols-2">
                @foreach ($children as $child)
                    <a href="{{ route('pages.show', $child->slug) }}" class="rounded-xl border border-stone-200 bg-white p-5 font-semibold hover:border-stone-400">{{ $child->title }} →</a>
                @endforeach
            </nav>
        @endif
    </article>
</x-layouts.site>
