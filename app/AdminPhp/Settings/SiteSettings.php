<?php

namespace App\AdminPhp\Settings;

use App\Models\Page;
use Gmarineau\AdminPhp\Fields\Image;
use Gmarineau\AdminPhp\Fields\Select;
use Gmarineau\AdminPhp\Fields\Text;
use Gmarineau\AdminPhp\Settings\Settings;

class SiteSettings extends Settings
{
    protected string $description = 'Réglages du site.';

    public function form(): array
    {
        return [
            Text::make('site_name')->label('Nom du site')->required(),
            Text::make('tagline')->label('Slogan')->translatable(),
            Select::make('homepage')->label('Page d’accueil')->options(
                fn (): array => Page::query()->whereNull('parent_id')->orderBy('position')->get()
                    ->mapWithKeys(fn (Page $page): array => [$page->id => $page->title])
                    ->all(),
            ),
            Image::make('logo')->label('Logo'),
            Text::make('contact_email')->label('E-mail de contact'),
        ];
    }
}
