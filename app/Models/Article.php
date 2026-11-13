<?php

namespace App\Models;

use Gmarineau\AdminPhp\Concerns\HasBlocks;
use Gmarineau\AdminPhp\Concerns\HasPublication;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasBlocks, HasPublication, HasTranslations, HasUlids, SoftDeletes;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['title'];
}
