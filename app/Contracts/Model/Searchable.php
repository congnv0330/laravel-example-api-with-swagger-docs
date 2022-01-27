<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Builder;

interface Searchable
{
    public function scopeSearch(Builder $query, string $value): Builder;
}
