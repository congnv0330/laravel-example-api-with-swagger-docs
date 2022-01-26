<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail_image',
        'cover_image',
        'status',
        'creator_id',
        'updater_id'
    ];

    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'reference');;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_has_tags');
    }
}
