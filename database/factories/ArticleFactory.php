<?php

namespace Database\Factories;

use App\Models\Article;
use Gmarineau\AdminPhp\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Bare articles for tests: columns only, no blocks nor revisions.
 * DemoContentSeeder goes through the admin actions for a realistic content.
 *
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = rtrim(fake('fr_FR')->sentence(5), '.');

        return [
            'title' => ['fr' => $title, 'en' => rtrim(fake()->sentence(5), '.')],
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(4)),
            'lead' => ['fr' => fake('fr_FR')->paragraph()],
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => [
            'status' => PublicationStatus::Published,
            'published_at' => fake()->dateTimeBetween('-6 months'),
        ]);
    }

    public function scheduled(): static
    {
        return $this->published()->state(fn (): array => [
            'publish_start_at' => fake()->dateTimeBetween('+1 day', '+1 month'),
        ]);
    }

    public function expired(): static
    {
        return $this->published()->state(fn (): array => [
            'publish_end_at' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}
