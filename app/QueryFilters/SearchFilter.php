<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends Filter
{
    public function handle(Builder $query, Closure $next)
    {
        if ($this->request->filled('q')) {
            $query = $query->search($this->request->query('q'));
        }

        return $next($query);
    }
}
