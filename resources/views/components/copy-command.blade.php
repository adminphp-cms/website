{{-- A shell command with a button that copies it (resources/js/app.js). --}}
@props(['command'])

<div {{ $attributes->class('flex items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-50 py-2 pr-2 pl-4 text-left font-mono text-sm dark:border-zinc-800 dark:bg-zinc-900') }}>
    <span class="text-zinc-400 select-none" aria-hidden="true">$</span>
    <code class="min-w-0 flex-1 overflow-x-auto py-1 whitespace-nowrap text-zinc-900 [scrollbar-width:none] dark:text-zinc-100">{{ $command }}</code>
    <button
        type="button"
        data-copy="{{ $command }}"
        class="shrink-0 rounded-lg px-3 py-1.5 font-sans text-xs font-semibold text-zinc-600 hover:bg-zinc-200 hover:text-zinc-950 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white"
    >Copier</button>
</div>
