<?php

namespace App\AdminPhp\Blocks;

use AdminPhp\Blocks\Block;
use AdminPhp\Fields\Image;
use AdminPhp\Fields\Text;

class ImageBlock extends Block
{
    protected string $title = 'Image';

    public function form(): array
    {
        return [
            Image::make('image')->label('Image')->required(),
            Text::make('alt')->label('Texte alternatif')->translatable()
                ->note('Décrit l’image pour les personnes qui ne la voient pas.'),
            Text::make('caption')->label('Légende')->translatable(),
        ];
    }
}
