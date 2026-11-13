<?php

namespace App\View\Composers;

use App\Models\Page;
use Gmarineau\AdminPhp\AdminPhp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

/**
 * Site name and main menu of the layout: the published pages at the top of the tree.
 */
class SiteLayoutComposer
{
    /**
     * @var Collection<int, Page>|null
     */
    protected ?Collection $navigation = null;

    public function __construct(protected AdminPhp $adminPhp) {}

    public function compose(View $view): void
    {
        $this->navigation ??= Page::query()
            ->published()
            ->whereNull('parent_id')
            ->whereKeyNot($this->adminPhp->setting('homepage') ?? '')
            ->orderBy('position')
            ->get();

        $view->with([
            'siteName' => $this->adminPhp->setting('site_name', config('app.name')),
            'tagline' => $this->adminPhp->setting('tagline'),
            'navigation' => $this->navigation,
        ]);
    }
}
