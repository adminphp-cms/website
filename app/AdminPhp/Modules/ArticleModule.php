<?php

namespace App\AdminPhp\Modules;

use App\Models\Article;
use Gmarineau\AdminPhp\Fields\Blocks;
use Gmarineau\AdminPhp\Fields\Slug;
use Gmarineau\AdminPhp\Fields\Text;
use Gmarineau\AdminPhp\Modules\Module;

class ArticleModule extends Module
{
    protected string $model = Article::class;

    protected string $description = '';

    protected string $icon = 'file-text';

    public function form(): array
    {
        return [
            Text::make('title')->label('Titre')->translatable()->required(),
            Slug::make('slug')->label('Adresse')->from('title')->prefix('/articles/'),
            Blocks::make('content')->label('Contenu')->allow([]),
        ];
    }
}
