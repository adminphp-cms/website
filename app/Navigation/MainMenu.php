<?php

namespace App\Navigation;

use AdminPhp\AdminPhp;
use AdminPhp\Models\Related;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * The main menu as the site shows it, in a fixed number of queries: links to offline
 * contents are left out, and so are submenu headings left without any link.
 */
class MainMenu
{
    public function __construct(protected AdminPhp $adminPhp) {}

    /**
     * @return Collection<int, MenuLink>
     */
    public function links(): Collection
    {
        $items = MenuItem::query()->with('relatedItems')->orderBy('position')->get();

        $references = $items->map->targetReference()->filter()->values()->all();
        $targets = Related::resolve($references)->keyBy(fn ($model): string => $model->getMorphClass().':'.$model->getKey());
        $homepageId = $this->adminPhp->setting('homepage');

        $link = function (MenuItem $item, Collection $children) use ($targets, $homepageId): ?MenuLink {
            $reference = $item->targetReference();
            $target = $reference ? $targets->get($reference['type'].':'.$reference['id']) : null;
            $href = $item->hrefTo($target, $homepageId);

            if ($href === null && $children->isEmpty()) {
                return null;
            }

            return new MenuLink($item->title, $href, $item->opens_in_new_tab, $children);
        };

        /** @var EloquentCollection<string, EloquentCollection<int, MenuItem>> $childrenByParent */
        $childrenByParent = $items->whereNotNull('parent_id')->groupBy('parent_id');

        return $items->whereNull('parent_id')
            ->map(fn (MenuItem $item): ?MenuLink => $link(
                $item,
                collect($childrenByParent->get($item->id, []))->map(fn (MenuItem $child): ?MenuLink => $link($child, collect()))->filter()->values(),
            ))
            ->filter()
            ->values();
    }
}
