<?php

use App\AdminPhp\Modules\ArticleModule;
use App\AdminPhp\Modules\PageModule;
use App\Models\Article;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function textBlock(string $text): array
{
    return ['type' => 'text', 'content' => ['body' => ['fr' => ['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $text]]]]]]]];
}

it('presents AdminPHP on the homepage', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Le CMS Laravel qui reste')
        ->assertSee('composer require adminphp-cms/core')
        ->assertSee('&#123;&#123;-- projects/show.blade.php --&#125;&#125;', false)
        ->assertSee('{{ $project->title }}', false)
        ->assertSee('@foreach', false)
        ->assertSee('https://github.com/adminphp-cms/starter');
});

it('lists only the articles online, newest first', function () {
    Article::factory()->published()->create(['title' => ['fr' => 'Ancien'], 'published_at' => now()->subMonth()]);
    Article::factory()->published()->create(['title' => ['fr' => 'Récent'], 'published_at' => now()->subDay()]);
    Article::factory()->create(['title' => ['fr' => 'Brouillon']]);
    Article::factory()->scheduled()->create(['title' => ['fr' => 'Programmé']]);
    Article::factory()->expired()->create(['title' => ['fr' => 'Expiré']]);

    $this->get('/articles')
        ->assertOk()
        ->assertSeeInOrder(['Récent', 'Ancien'])
        ->assertDontSee('Brouillon')
        ->assertDontSee('Programmé')
        ->assertDontSee('Expiré');
});

it('shows an article online with its blocks', function () {
    $article = Article::factory()->published()->create(['title' => ['fr' => 'Rénover un toit'], 'slug' => 'renover-un-toit']);
    $article->blocks()->create(['editor_name' => 'content', 'type' => 'quote', 'position' => 0, 'content' => ['quote' => ['fr' => 'On commence par le haut.'], 'author' => 'Claire']]);

    $this->get('/articles/renover-un-toit')
        ->assertOk()
        ->assertSee('Rénover un toit')
        ->assertSee('On commence par le haut.')
        ->assertSee('Claire');
});

it('hides the articles that are not online', function (string $state) {
    Article::factory()->{$state}()->create(['slug' => 'cache']);

    $this->get('/articles/cache')->assertNotFound();
})->with(['scheduled', 'expired']);

it('hides a draft or trashed article', function () {
    Article::factory()->create(['slug' => 'brouillon']);
    Article::factory()->published()->create(['slug' => 'supprime'])->delete();

    $this->get('/articles/brouillon')->assertNotFound();
    $this->get('/articles/supprime')->assertNotFound();
});

it('shows a page with its parent and its children online, and the menu', function () {
    $services = Page::factory()->published()->create(['title' => ['fr' => 'Services'], 'slug' => 'services']);
    $renovation = Page::factory()->published()->childOf($services)->create(['title' => ['fr' => 'Rénovation'], 'slug' => 'renovation']);
    Page::factory()->childOf($services)->create(['title' => ['fr' => 'Sous-page brouillon']]);
    Page::factory()->create(['title' => ['fr' => 'Racine brouillon']]);

    $this->get('/services')
        ->assertOk()
        ->assertSee('Rénovation')
        ->assertDontSee('Sous-page brouillon')
        ->assertDontSee('Racine brouillon');

    $this->get('/renovation')
        ->assertOk()
        ->assertSee('← Services');
});

it('returns a 404 for an unknown or draft page', function () {
    Page::factory()->create(['slug' => 'brouillon']);

    $this->get('/brouillon')->assertNotFound();
    $this->get('/inconnue')->assertNotFound();
});

it('leaves the admin address to the admin', function () {
    Page::factory()->published()->create(['slug' => config('adminphp.path')]);

    $this->get('/'.config('adminphp.path'))->assertDontSee('<main', false);
});

it('renders the preview of an unsaved article and page', function () {
    $article = (new Article)->forceFill(['title' => ['fr' => 'Aperçu article'], 'slug' => 'apercu']);
    $page = (new Page)->forceFill(['title' => ['fr' => 'Aperçu page'], 'slug' => 'apercu-page']);

    expect((string) (new ArticleModule)->preview($article))->toContain('Aperçu article')
        ->and((string) (new PageModule)->preview($page))->toContain('Aperçu page');
});
