<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => ['fr' => fake('fr_FR')->word()],
        ];
    }

    public function to(Model $target): static
    {
        return $this->afterCreating(fn (MenuItem $item) => $item->relatedItems()->create([
            'browser_name' => 'target',
            'related_type' => $target->getMorphClass(),
            'related_id' => $target->getKey(),
            'position' => 0,
        ]));
    }

    public function childOf(MenuItem $parent): static
    {
        return $this->state(['parent_id' => $parent->getKey()]);
    }
}
