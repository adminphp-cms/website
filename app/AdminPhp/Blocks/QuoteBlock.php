<?php

namespace App\AdminPhp\Blocks;

use AdminPhp\Blocks\Block;
use AdminPhp\Fields\Text;

class QuoteBlock extends Block
{
    protected string $title = 'Citation';

    public function form(): array
    {
        return [
            Text::make('quote')->label('Citation')->translatable()->multiline()->required(),
            Text::make('author')->label('Auteur'),
        ];
    }
}
