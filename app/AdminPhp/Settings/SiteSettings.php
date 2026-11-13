<?php

namespace App\AdminPhp\Settings;

use AdminPhp\Fields\Image;
use AdminPhp\Fields\Select;
use AdminPhp\Fields\Text;
use AdminPhp\Settings\Settings;
use App\Models\Page;

class SiteSettings extends Settings
{
    protected string $description = 'Réglages du site.';

    public function form(): array
    {
        return [
            Text::make('site_name')->label('Nom du site')->required()->note('Titre des onglets et en-tête du site.'),
            Text::make('tagline')->label('Slogan')->translatable()->note('Affiché dans le pied de page.'),
            Select::make('homepage')->label('Page d’accueil')->options(
                fn (): array => Page::query()->whereNull('parent_id')->orderBy('position')->get()
                    ->mapWithKeys(fn (Page $page): array => [$page->id => $page->title])
                    ->all(),
            ),
            Image::make('logo')->label('Logo'),
            Text::make('contact_email')->label('E-mail de contact')->email()->placeholder('contact@exemple.ch'),
        ];
    }
}
