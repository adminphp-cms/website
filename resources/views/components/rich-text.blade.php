@props(['document'])

<div {{ $attributes->merge(['class' => 'space-y-4 leading-relaxed [&_a]:underline [&_blockquote]:border-l-4 [&_blockquote]:border-stone-300 [&_blockquote]:pl-4 [&_h2]:text-2xl [&_h2]:font-semibold [&_h3]:text-xl [&_h3]:font-semibold [&_ol]:list-decimal [&_ol]:pl-6 [&_ul]:list-disc [&_ul]:pl-6']) }}>
    {{ App\Support\RichText::toHtml($document) }}
</div>
