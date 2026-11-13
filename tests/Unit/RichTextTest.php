<?php

use App\Support\RichText;

it('renders the nodes and marks of the editor', function () {
    $html = (string) RichText::toHtml(['type' => 'doc', 'content' => [
        ['type' => 'heading', 'attrs' => ['level' => 2], 'content' => [['type' => 'text', 'text' => 'Titre']]],
        ['type' => 'paragraph', 'content' => [
            ['type' => 'text', 'text' => 'gras', 'marks' => [['type' => 'bold']]],
            ['type' => 'hardBreak'],
            ['type' => 'text', 'text' => 'lien', 'marks' => [['type' => 'link', 'attrs' => ['href' => 'https://example.com']]]],
        ]],
        ['type' => 'bulletList', 'content' => [['type' => 'listItem', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => 'un']]]]]]],
    ]]);

    expect($html)->toBe('<h2>Titre</h2><p><strong>gras</strong><br><a href="https://example.com" rel="noopener">lien</a></p><ul><li><p>un</p></li></ul>');
});

it('escapes the text and drops unsafe links', function () {
    $html = (string) RichText::toHtml(['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [
        ['type' => 'text', 'text' => '<script>x</script>'],
        ['type' => 'text', 'text' => 'clic', 'marks' => [['type' => 'link', 'attrs' => ['href' => 'javascript:alert(1)']]]],
    ]]]]);

    expect($html)->toBe('<p>&lt;script&gt;x&lt;/script&gt;clic</p>');
});

it('renders nothing for an empty value', function () {
    expect((string) RichText::toHtml(null))->toBe('');
});
