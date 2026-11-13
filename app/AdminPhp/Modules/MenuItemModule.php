<?php

namespace App\AdminPhp\Modules;

use AdminPhp\Fields\Browser;
use AdminPhp\Fields\Text;
use AdminPhp\Fields\Toggle;
use AdminPhp\Modules\Module;
use App\Models\MenuItem;

/**
 * Links of the main menu of the site, on two levels, ordered by hand.
 */
class MenuItemModule extends Module
{
    protected string $model = MenuItem::class;

    protected string $title = 'Menu';

    protected string $description = 'Liens du menu principal, sur deux niveaux.';

    protected string $icon = 'menu';

    protected int $nestingDepth = 1;

    public function form(): array
    {
        return [
            Text::make('title')->label('Libellé')->translatable()->required(),
            Browser::make('target')->label('Page ou article')->modules([PageModule::class, ArticleModule::class])->max(1)
                ->note('Le lien disparaît du menu tant que ce contenu n’est pas en ligne.'),
            Text::make('url')->label('Ou adresse')->placeholder('/articles ou https://…')
                ->rules(['regex:~^(https?://|/)~'])
                ->note('Utilisée quand aucun contenu n’est choisi. Laisser vide pour un simple intitulé de sous-menu.'),
            Toggle::make('opens_in_new_tab')->label('Nouvel onglet'),
        ];
    }
}
