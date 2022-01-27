<?php

namespace App\Models;

use App\Contracts\Model\Searchable;
use App\Supports\Model\Filterable;
use App\Supports\Model\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model implements Searchable
{
    use HasFactory;
    use HasSlug;
    use Filterable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail_image',
        'cover_image',
        'sort_order',
        'status',
        'creator_id',
        'updater_id'
    ];

    public const columnsNoContent = [
        'id',
        'title',
        'description',
        'thumbnail_image',
        'cover_image',
        'sort_order',
        'creator_id',
        'updater_id',
        'created_at',
        'updated_at'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'name', 'email']);
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->select(['id', 'name', 'email']);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_has_tags');
    }

    public function scopeSearch(Builder $query, string $value): Builder
    {
        return $query->whereFullText(
            ['title', 'description', 'content'],
            $value,
            ['mode' => 'boolean']
        );
    }
}
