<blockquote class="border-l-4 border-amber-500 pl-6">
    <p class="text-xl italic text-stone-900">« {{ $block->translated('quote') }} »</p>
    @if ($block->content['author'] ?? null)
        <footer class="mt-2 text-sm text-stone-500">— {{ $block->content['author'] }}</footer>
    @endif
</blockquote>
