<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort_order'
    ];

    public function slug(): MorphOne
    {
        return $this->morphOne(Slug::class, 'reference');
    }

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, 'blog_has_tags');
    }
}
