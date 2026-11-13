<?php

namespace App\Models;

use AdminPhp\Concerns\HasBlocks;
use AdminPhp\Concerns\HasPublication;
use AdminPhp\Models\Media;
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
     * The image of the Couverture field, which stores the id of its media.
     *
     * @return BelongsTo<Media, $this>
     */
    public function coverMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover');
    }
}
