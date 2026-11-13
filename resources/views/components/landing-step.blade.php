{{-- A step of "Comment ça marche": its title and a code sample, already highlighted. --}}
@props(['number', 'title', 'text'])

<div class="flex flex-col">
    <div class="flex items-center gap-3">
        <span class="grid size-8 place-items-center rounded-full bg-brand text-sm font-semibold text-white">{{ $number }}</span>
        <h3 class="text-lg font-semibold text-zinc-950 dark:text-white">{{ $title }}</h3>
    </div>
    <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ $text }}</p>
    <pre class="mt-5 flex-1 overflow-x-auto rounded-xl bg-zinc-950 p-4 font-mono text-xs leading-relaxed text-zinc-300 ring-1 ring-zinc-900/10 dark:ring-white/10"><code>{{ $slot }}</code></pre>
</div>
