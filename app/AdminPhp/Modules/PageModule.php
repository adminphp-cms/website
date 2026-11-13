<?php

namespace App\AdminPhp\Modules;

use App\AdminPhp\Blocks\ImageBlock;
use App\AdminPhp\Blocks\QuoteBlock;
use App\AdminPhp\Blocks\TextBlock;
use App\Models\Page;
use Gmarineau\AdminPhp\Fields\Blocks;
use Gmarineau\AdminPhp\Fields\Slug;
use Gmarineau\AdminPhp\Fields\Text;
use Gmarineau\AdminPhp\Modules\Module;
use Illuminate\Database\Eloquent\Model;

class PageModule extends Module
{
    protected string $model = Page::class;

    protected string $description = 'Pages du site, rangées en arborescence.';

    protected string $icon = 'file-text';

    protected int $nestingDepth = 1;

    protected ?string $previewView = 'pages.show';

    public function form(): array
    {
        return [
            Text::make('title')->label('Titre')->translatable()->required(),
            Slug::make('slug')->label('Adresse')->from('title')->prefix('/'),
            Blocks::make('content')->label('Contenu')->allow([TextBlock::class, ImageBlock::class, QuoteBlock::class]),
        ];
    }

    protected function previewData(Model $item): array
    {
        return [
            ...parent::previewData($item),
            'parent' => $item->parent()->published()->first(),
            'children' => $item->exists ? $item->children()->published()->get() : collect(),
        ];
    }
}
