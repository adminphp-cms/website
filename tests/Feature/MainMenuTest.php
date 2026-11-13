<?php

use AdminPhp\Actions\SaveModuleContent;
use AdminPhp\Models\Setting;
use App\AdminPhp\Modules\MenuItemModule;
use App\Models\Article;
use App\Models\MenuItem;
use App\Models\Page;
use App\Navigation\MainMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

it('links to the chosen page or article, or to the typed address', function () {
    $page = Page::factory()->published()->create(['title' => ['fr' => 'Contact'], 'slug' => 'contact']);
    $article = Article::factory()->published()->create(['slug' => 'chantier']);
    MenuItem::factory()->to($page)->create(['title' => ['fr' => 'Nous écrire']]);
    MenuItem::factory()->to($article)->create(['title' => ['fr' => 'Chantier']]);
    MenuItem::factory()->create(['title' => ['fr' => 'Blog'], 'url' => '/articles']);
    MenuItem::factory()->create(['title' => ['fr' => 'Instagram'], 'url' => 'https://www.instagram.com/', 'opens_in_new_tab' => true]);

    $links = app(MainMenu::class)->links();

    expect($links->pluck('title')->all())->toBe(['Nous écrire', 'Chantier', 'Blog', 'Instagram'])
        ->and($links->pluck('href')->all())->toBe([url('/contact'), url('/articles/chantier'), '/articles', 'https://www.instagram.com/'])
        ->and($links->pluck('opensInNewTab')->all())->toBe([false, false, false, true]);
});

it('links the homepage to the root of the site', function () {
    $home = Page::factory()->published()->create(['slug' => 'accueil']);
    Setting::query()->create(['key' => 'homepage', 'value' => $home->id]);
    MenuItem::factory()->to($home)->create();

    expect(app(MainMenu::class)->links()->first()->href)->toBe(route('home'));
});

it('leaves out links to offline contents, even with an address typed', function () {
    MenuItem::factory()->to(Page::factory()->create())->create(['title' => ['fr' => 'Brouillon'], 'url' => '/ignoree']);
    MenuItem::factory()->to(Article::factory()->scheduled()->create())->create(['title' => ['fr' => 'Programmé']]);
    $trashed = Page::factory()->published()->create();
    MenuItem::factory()->to($trashed)->create(['title' => ['fr' => 'Supprimée']]);
    $trashed->delete();

    expect(app(MainMenu::class)->links())->toBeEmpty();
});

it('nests the submenus in their order and drops headings left empty', function () {
    $services = MenuItem::factory()->create(['title' => ['fr' => 'Services']]);
    MenuItem::factory()->childOf($services)->create(['title' => ['fr' => 'Conseil'], 'url' => '/conseil']);
    MenuItem::factory()->childOf($services)->to(Page::factory()->create())->create(['title' => ['fr' => 'Brouillon']]);
    MenuItem::factory()->childOf($services)->create(['title' => ['fr' => 'Rénovation'], 'url' => '/renovation']);
    MenuItem::factory()->create(['title' => ['fr' => 'Vide']]);
    $empty = MenuItem::factory()->create(['title' => ['fr' => 'Sous-menu hors ligne']]);
    MenuItem::factory()->childOf($empty)->to(Page::factory()->create())->create();

    $links = app(MainMenu::class)->links();

    expect($links)->toHaveCount(1)
        ->and($links->first()->title)->toBe('Services')
        ->and($links->first()->href)->toBeNull()
        ->and($links->first()->children->pluck('title')->all())->toBe(['Conseil', 'Rénovation']);
});

it('builds the menu in a fixed number of queries', function () {
    foreach (range(1, 6) as $index) {
        $parent = MenuItem::factory()->to(Page::factory()->published()->create())->create();
        MenuItem::factory()->childOf($parent)->to(Article::factory()->published()->create())->create();
    }

    DB::enableQueryLog();
    app(MainMenu::class)->links();

    expect(count(DB::getQueryLog()))->toBeLessThanOrEqual(6);
});

it('shows the menu on the site, with its submenu and the current page', function () {
    $about = Page::factory()->published()->create(['title' => ['fr' => 'À propos'], 'slug' => 'a-propos']);
    $team = Page::factory()->published()->childOf($about)->create(['title' => ['fr' => 'Équipe'], 'slug' => 'equipe']);
    $parent = MenuItem::factory()->to($about)->create(['title' => ['fr' => 'À propos']]);
    MenuItem::factory()->childOf($parent)->to($team)->create(['title' => ['fr' => 'L’équipe']]);
    MenuItem::factory()->create(['title' => ['fr' => 'Instagram'], 'url' => 'https://www.instagram.com/', 'opens_in_new_tab' => true]);

    $this->get('/equipe')
        ->assertOk()
        ->assertSee('<summary', false)
        ->assertSee('href="'.url('/equipe').'"', false)
        ->assertSee('aria-current="page"', false)
        ->assertSee('target="_blank" rel="noopener"', false);
});

it('refuses an address that is neither a path nor a web address', function (string $url) {
    app(SaveModuleContent::class)->handle(new MenuItemModule, ['title' => ['fr' => 'Lien'], 'url' => $url]);
})->with(['javascript:alert(1)', 'articles', 'mailto:a@example.com'])->throws(ValidationException::class);
