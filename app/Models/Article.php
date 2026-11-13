<?php

namespace App\Models;

use Gmarineau\AdminPhp\Concerns\HasBlocks;
use Gmarineau\AdminPhp\Concerns\HasPublication;
use Gmarineau\AdminPhp\Models\Asset;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasBlocks, HasFactory, HasPublication, HasTranslations, HasUlids, SoftDeletes;

    /**
     * @var array<int, string>
     */
    public array $translatable = ['title', 'lead'];

    /**
     * The image of the Couverture field, which stores the id of its asset.
     *
     * @return BelongsTo<Asset, $this>
     */
    public function coverAsset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'cover');
    }
}
