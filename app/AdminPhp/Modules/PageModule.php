<?php

namespace App\AdminPhp\Modules;

use App\Models\Page;
use Gmarineau\AdminPhp\Fields\Blocks;
use Gmarineau\AdminPhp\Fields\Slug;
use Gmarineau\AdminPhp\Fields\Text;
use Gmarineau\AdminPhp\Modules\Module;

class PageModule extends Module
{
    protected string $model = Page::class;

    protected string $description = '';

    protected string $icon = 'file-text';

    protected int $nestingDepth = 1;

    public function form(): array
    {
        return [
            Text::make('title')->label('Titre')->translatable()->required(),
            Slug::make('slug')->label('Adresse')->from('title')->prefix('/pages/'),
            Blocks::make('content')->label('Contenu')->allow([]),
        ];
    }
}
