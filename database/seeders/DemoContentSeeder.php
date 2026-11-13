<?php

namespace Database\Seeders;

use App\AdminPhp\Modules\ArticleModule;
use App\AdminPhp\Modules\PageModule;
use App\AdminPhp\Settings\SiteSettings;
use App\Models\Page;
use Gmarineau\AdminPhp\Actions\PublishItem;
use Gmarineau\AdminPhp\Actions\SaveDraft;
use Gmarineau\AdminPhp\Actions\SaveModuleContent;
use Gmarineau\AdminPhp\Actions\StoreAsset;
use Gmarineau\AdminPhp\Actions\SyncAssetUsages;
use Gmarineau\AdminPhp\Models\Asset;
use Gmarineau\AdminPhp\Models\User;
use Gmarineau\AdminPhp\Modules\Module;
use Gmarineau\AdminPhp\Settings\SettingsStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

/**
 * Demo content for the admin, created through the same actions as the admin itself
 * (blocks, revisions, image usages…).
 *
 * Accounts (password "password"): admin@example.com (admin), editor@example.com (editor).
 */
class DemoContentSeeder extends Seeder
{
    /**
     * @var array<int, Asset>
     */
    protected array $images = [];

    public function run(): void
    {
        // Make the image variants now rather than through the queue worker.
        config(['queue.default' => 'sync']);

        $this->users();
        $this->images = $this->images();
        $this->pages();
        $this->settings();
        $this->articles();
    }

    protected function users(): void
    {
        User::factory()->create(['name' => 'Admin Démo', 'email' => 'admin@example.com']);
        User::factory()->editor()->create(['name' => 'Éditrice Démo', 'email' => 'editor@example.com']);
        User::factory()->editor()->invited()->create(['name' => 'Invité Démo', 'email' => 'invited@example.com']);
        User::factory()->editor()->deactivated()->create(['name' => 'Ancien Rédacteur', 'email' => 'former@example.com']);
    }

    /**
     * @return array<int, Asset>
     */
    protected function images(): array
    {
        $palette = [
            ['Atelier', [37, 99, 235], [14, 165, 233]],
            ['Chantier', [234, 88, 12], [250, 204, 21]],
            ['Forêt', [22, 101, 52], [132, 204, 22]],
            ['Façade', [124, 58, 237], [236, 72, 153]],
            ['Toiture', [71, 85, 105], [148, 163, 184]],
            ['Jardin', [5, 150, 105], [45, 212, 191]],
        ];

        return array_map(fn (array $image): Asset => $this->storeImage(...$image), $palette);
    }

    /**
     * @param  array{int, int, int}  $from
     * @param  array{int, int, int}  $to
     */
    protected function storeImage(string $label, array $from, array $to): Asset
    {
        [$width, $height] = [1600, 1000];
        $image = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; $y++) {
            $ratio = $y / $height;
            $color = imagecolorallocate(
                $image,
                (int) ($from[0] + ($to[0] - $from[0]) * $ratio),
                (int) ($from[1] + ($to[1] - $from[1]) * $ratio),
                (int) ($from[2] + ($to[2] - $from[2]) * $ratio),
            );
            imageline($image, 0, $y, $width, $y, $color);
        }

        $white = imagecolorallocate($image, 255, 255, 255);
        $font = 5;
        $scale = 6;
        $text = imagecreatetruecolor(imagefontwidth($font) * strlen($label), imagefontheight($font));
        imagecolortransparent($text, imagecolorallocate($text, 0, 0, 0));
        imagestring($text, $font, 0, 0, $label, $white);
        $textWidth = imagesx($text) * $scale;
        $textHeight = imagesy($text) * $scale;
        imagecopyresized($image, $text, (int) (($width - $textWidth) / 2), (int) (($height - $textHeight) / 2), 0, 0, $textWidth, $textHeight, imagesx($text), imagesy($text));

        $path = tempnam(sys_get_temp_dir(), 'adminphp-demo').'.jpg';
        imagejpeg($image, $path, 85);

        return app(StoreAsset::class)->handle(new UploadedFile($path, str($label)->slug().'.jpg', 'image/jpeg', null, true));
    }

    protected function settings(): void
    {
        $settings = new SiteSettings;

        app(SettingsStore::class)->save($settings, [
            'site_name' => 'Atelier Démo',
            'tagline' => ['fr' => 'Rénover avec soin, depuis 1998', 'en' => 'Careful renovation since 1998'],
            'logo' => $this->images[0]->id,
            'homepage' => Page::query()->where('slug', 'accueil')->value('id'),
            'contact_email' => 'contact@example.com',
        ]);

        app(SyncAssetUsages::class)->forSettings($settings);
    }

    protected function pages(): void
    {
        $tree = [
            ['Accueil', 'Home', 'accueil', []],
            ['À propos', 'About', 'a-propos', [
                ['L’équipe', 'Team', 'equipe'],
                ['Notre histoire', 'Our story', 'histoire'],
            ]],
            ['Services', 'Services', 'services', [
                ['Rénovation', 'Renovation', 'renovation'],
                ['Conseil', 'Advice', 'conseil'],
                ['Extension bois', 'Timber extension', 'extension-bois', 'draft'],
            ]],
            ['Contact', 'Contact', 'contact', []],
            ['Mentions légales', 'Legal notice', 'mentions-legales', []],
        ];

        $module = new PageModule;

        foreach ($tree as [$fr, $en, $slug, $children]) {
            $parent = $this->publish($module, $this->save($module, $this->pageInput($fr, $en, $slug)));

            foreach ($children as $child) {
                [$childFr, $childEn, $childSlug] = $child;
                $page = $this->save($module, $this->pageInput($childFr, $childEn, $childSlug), (new Page)->forceFill(['parent_id' => $parent->id]));

                if (($child[3] ?? null) !== 'draft') {
                    $this->publish($module, $page);
                }
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function pageInput(string $fr, string $en, string $slug): array
    {
        return [
            'title' => ['fr' => $fr, 'en' => $en],
            'slug' => $slug,
            'content' => [
                $this->textBlock(2),
                $this->imageBlock(),
                $this->textBlock(1),
            ],
        ];
    }

    protected function articles(): void
    {
        $module = new ArticleModule;
        $faker = fake('fr_FR');

        // [state, published days ago]
        $plan = [
            ...array_fill(0, 9, 'live'),
            'draft', 'draft', 'draft',
            'scheduled', 'scheduled',
            'expired',
            'pending-changes',
            'trashed', 'trashed',
        ];

        foreach ($plan as $index => $state) {
            $title = rtrim($faker->sentence(random_int(4, 8)), '.');

            $input = [
                'title' => ['fr' => $title, 'en' => rtrim(fake()->sentence(random_int(4, 8)), '.')],
                'slug' => str($title)->slug()->limit(60, '')->toString().'-'.($index + 1),
                'lead' => ['fr' => $faker->paragraph(2), 'en' => fake()->paragraph(2)],
                'cover' => $index % 4 === 3 ? null : $this->randomImage()->id,
                'content' => $this->articleBlocks(),
            ];

            $article = $this->save($module, $input);

            match ($state) {
                'live', 'trashed', 'pending-changes' => $this->publish($module, $article),
                'scheduled' => $this->publish($module, $article, start: now()->addDays(random_int(2, 20))->setTime(9, 0)),
                'expired' => $this->publish($module, $article, start: now()->subMonths(2), end: now()->subWeek()),
                'draft' => null,
            };

            if ($state !== 'draft') {
                $article->forceFill(['published_at' => Carbon::instance(fake()->dateTimeBetween('-6 months', '-1 day'))])->saveQuietly();
            }

            if ($state === 'pending-changes') {
                app(SaveDraft::class)->handle($module, $article, ['title' => ['fr' => $title.' (mise à jour)', 'en' => $input['title']['en']]]);
            }

            if ($state === 'trashed') {
                $article->delete();
            }
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function articleBlocks(): array
    {
        $blocks = [$this->textBlock(random_int(2, 3))];

        foreach (range(1, random_int(1, 3)) as $ignored) {
            $blocks[] = match (random_int(1, 3)) {
                1 => $this->imageBlock(),
                2 => $this->quoteBlock(),
                3 => $this->textBlock(random_int(1, 2)),
            };
        }

        return $blocks;
    }

    /**
     * @return array<string, mixed>
     */
    protected function textBlock(int $paragraphs): array
    {
        $doc = fn (string $locale): array => [
            'type' => 'doc',
            'content' => array_map(
                fn (string $text): array => ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $text]]],
                fake($locale)->paragraphs($paragraphs),
            ),
        ];

        return ['type' => 'text', 'content' => ['body' => ['fr' => $doc('fr_FR'), 'en' => $doc('en_US')]]];
    }

    /**
     * @return array<string, mixed>
     */
    protected function imageBlock(): array
    {
        $image = $this->randomImage();

        return ['type' => 'image', 'content' => [
            'image' => $image->id,
            'alt' => ['fr' => 'Illustration : '.pathinfo($image->name, PATHINFO_FILENAME)],
            'caption' => ['fr' => rtrim(fake('fr_FR')->sentence(), '.')],
        ]];
    }

    /**
     * @return array<string, mixed>
     */
    protected function quoteBlock(): array
    {
        return ['type' => 'quote', 'content' => [
            'quote' => ['fr' => fake('fr_FR')->sentence(14), 'en' => fake()->sentence(14)],
            'author' => fake('fr_FR')->name(),
        ]];
    }

    protected function randomImage(): Asset
    {
        return $this->images[array_rand($this->images)];
    }

    /**
     * @param  array<string, mixed>  $input
     */
    protected function save(Module $module, array $input, ?Model $model = null): Model
    {
        return app(SaveModuleContent::class)->handle($module, $input, $model);
    }

    protected function publish(Module $module, Model $model, ?Carbon $start = null, ?Carbon $end = null): Model
    {
        return app(PublishItem::class)->handle($module, $model, publishStartAt: $start, publishEndAt: $end);
    }
}
