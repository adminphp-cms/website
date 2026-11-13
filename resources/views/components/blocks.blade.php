{{-- The blocks of a Blocks field, each rendered by resources/views/blocks/{type}.blade.php. --}}
@props(['blocks'])

<div {{ $attributes->merge(['class' => 'space-y-8']) }}>
    @foreach ($blocks as $block)
        @includeFirst(["blocks.{$block->type}", 'blocks.unknown'], ['block' => $block])
    @endforeach
</div>
