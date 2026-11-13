{{-- The main menu: a submenu opens on click, tap or keyboard (details), no script needed. --}}
@props(['links'])

<nav aria-label="Menu principal">
    <ul class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
        @foreach ($links as $link)
            <li class="relative">
                @if ($link->children->isEmpty())
                    <x-menu-link :link="$link" />
                @else
                    <details class="group">
                        <summary @class([
                            'flex cursor-pointer list-none items-center gap-1 hover:text-stone-950 [&::-webkit-details-marker]:hidden',
                            'font-semibold text-stone-950' => $link->isActive(),
                        ])>
                            {{ $link->title }}
                            <svg class="size-3 transition group-open:rotate-180" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m3 4.5 3 3 3-3" /></svg>
                        </summary>
                        <ul class="absolute right-0 z-10 mt-3 min-w-48 space-y-1 rounded-lg border border-stone-200 bg-white p-2 shadow-lg">
                            @if ($link->href)
                                <li><x-menu-link :link="$link" class="block rounded px-3 py-2 hover:bg-stone-100" /></li>
                            @endif
                            @foreach ($link->children as $child)
                                <li><x-menu-link :link="$child" class="block rounded px-3 py-2 hover:bg-stone-100" /></li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
