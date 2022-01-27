<?php

namespace App\Supports\Model;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSlug
{
    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'reference');
    }

    public function getSlugUrlAttribute(): string
    {
        return $this->slug?->value;
    }
}
