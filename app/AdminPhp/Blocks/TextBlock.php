<?php

namespace App\AdminPhp\Blocks;

use Gmarineau\AdminPhp\Blocks\Block;
use Gmarineau\AdminPhp\Fields\RichText;

class TextBlock extends Block
{
    protected string $title = 'Paragraphe';

    public function form(): array
    {
        return [
            RichText::make('body')->label('Texte')->translatable()->required(),
        ];
    }
}
