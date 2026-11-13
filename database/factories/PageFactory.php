<?php

namespace Database\Factories;

use AdminPhp\Enums\PublicationStatus;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Bare pages for tests: columns only, no blocks nor revisions.
 *
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::ucfirst(fake('fr_FR')->words(2, true));

        return [
            'title' => ['fr' => $title],
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(4)),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => [
            'status' => PublicationStatus::Published,
            'published_at' => now(),
        ]);
    }

    public function childOf(Page $parent): static
    {
        return $this->state(['parent_id' => $parent->getKey()]);
    }
}
