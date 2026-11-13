<?php

namespace App\View\Composers;

use AdminPhp\AdminPhp;
use App\Navigation\MainMenu;
use App\Navigation\MenuLink;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Site name, tagline and main menu of the layout.
 */
class SiteLayoutComposer
{
    /**
     * @var Collection<int, MenuLink>|null
     */
    protected ?Collection $navigation = null;

    public function __construct(protected AdminPhp $adminPhp, protected MainMenu $mainMenu) {}

    public function compose(View $view): void
    {
        $this->navigation ??= $this->mainMenu->links();

        $view->with([
            'siteName' => $this->adminPhp->setting('site_name', config('app.name')),
            'tagline' => $this->adminPhp->setting('tagline'),
            'navigation' => $this->navigation,
        ]);
    }
}
