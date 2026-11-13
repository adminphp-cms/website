<?php

namespace App\AdminPhp\Modules;

use AdminPhp\Fields\Blocks;
use AdminPhp\Fields\Image;
use AdminPhp\Fields\Slug;
use AdminPhp\Fields\Text;
use AdminPhp\Modules\Column;
use AdminPhp\Modules\Module;
use App\AdminPhp\Blocks\ImageBlock;
use App\AdminPhp\Blocks\QuoteBlock;
use App\AdminPhp\Blocks\TextBlock;
use App\Models\Article;

class ArticleModule extends Module
{
    protected string $model = Article::class;

    protected string $description = 'Actualités du site.';

    protected string $icon = 'newspaper';

    protected ?string $previewView = 'articles.show';

    public function columns(): array
    {
        return [
            Column::make('cover'),
            Column::make('title')->sortable(),
            Column::status(),
            Column::make('updated_at')->label('Modifié')->sortable(),
        ];
    }

    public function form(): array
    {
        return [
            Text::make('title')->label('Titre')->translatable()->required(),
            Slug::make('slug')->label('Adresse')->from('title')->prefix('/articles/'),
            Text::make('lead')->label('Chapeau')->translatable()->multiline()->maxLength(300)
                ->note('Résumé de deux ou trois phrases, repris dans la liste des articles.'),
            Image::make('cover')->label('Couverture'),
            Blocks::make('content')->label('Contenu')->allow([TextBlock::class, ImageBlock::class, QuoteBlock::class]),
        ];
    }
}
