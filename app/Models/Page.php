<?php

namespace App\Models;

use AdminPhp\Concerns\HasBlocks;
use AdminPhp\Concerns\HasNesting;
use AdminPhp\Concerns\HasPosition;
use AdminPhp\Concerns\HasPublication;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasBlocks, HasFactory, HasNesting, HasPosition, HasPublication, HasTranslations, HasUlids, SoftDeletes;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['title'];
}
