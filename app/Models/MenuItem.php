<?php

namespace App\Models;

use AdminPhp\Concerns\HasNesting;
use AdminPhp\Concerns\HasPosition;
use AdminPhp\Concerns\HasRelated;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasFactory, HasNesting, HasPosition, HasRelated, HasTranslations, HasUlids;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['title'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'opens_in_new_tab' => 'boolean',
        ];
    }

    /**
     * The page or article chosen in the Browser field, as stored: from the eager loaded relatedItems.
     *
     * @return array{type: string, id: string}|null
     */
    public function targetReference(): ?array
    {
        $related = $this->relatedItems->firstWhere('browser_name', 'target');

        return $related ? ['type' => $related->related_type, 'id' => $related->related_id] : null;
    }

    /**
     * Address of the link to the given chosen content (null when none is chosen or it is
     * offline), else the typed address. Null for a submenu heading or an offline content.
     */
    public function hrefTo(?Model $target, ?string $homepageId = null): ?string
    {
        if ($this->targetReference() === null) {
            return $this->url;
        }

        return match (true) {
            $target instanceof Page && $target->id === $homepageId => route('home'),
            $target instanceof Page => route('pages.show', $target->slug),
            $target instanceof Article => route('articles.show', $target->slug),
            default => null,
        };
    }
}
