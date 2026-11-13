<figure>
    <x-adminphp::image :asset="$block->asset('image')" :alt="$block->translated('alt') ?? ''" sizes="(min-width: 768px) 720px, 100vw" class="w-full rounded-lg" />
    @if ($caption = $block->translated('caption'))
        <figcaption class="mt-2 text-sm text-stone-500">{{ $caption }}</figcaption>
    @endif
</figure>
