<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Slug
 *
 * @property int $id
 * @property string $value
 * @property int $reference_id
 * @property string $reference_type
 * @property-read Model|\Eloquent $sluggable
 * @method static \Illuminate\Database\Eloquent\Builder|Slug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slug whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slug whereReferenceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slug whereValue($value)
 * @mixin \Eloquent
 */
class Slug extends Model
{
    public $timestamps = false;

    protected $fillable = ['value'];

    protected $hidden = [
        'reference_id',
        'reference_type',
    ];

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
