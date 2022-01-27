<?php

namespace App\Models;

use App\Contracts\Model\Searchable;
use App\Supports\Model\Filterable;
use App\Supports\Model\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model implements Searchable
{
    use HasFactory;
    use HasSlug;
    use Filterable;

    protected $fillable = [
        'name',
        'sort_order'
    ];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_has_tags');
    }

    public function scopeSearch(Builder $query, string $value): Builder
    {
        return $query->where('name', 'LIKE', "%$value%");
    }
}
