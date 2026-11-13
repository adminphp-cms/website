{{-- A block without its view yet: create resources/views/blocks/{{ $block->type }}.blade.php. --}}
@if (app()->isLocal())
    <p class="rounded border border-dashed border-amber-400 p-4 text-sm text-amber-700">Bloc « {{ $block->type }} » sans vue.</p>
@endif
