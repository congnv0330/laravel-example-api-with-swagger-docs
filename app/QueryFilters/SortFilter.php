<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class SortFilter extends Filter
{
    public function handle(Builder $query, Closure $next)
    {
        $sorts = $this->request->query('sort', []);

        foreach ($sorts as $sort) {
            [$key, $value] = $sort;
            $query = $query->orderBy($key, $value);
        }

        return $next($query);
    }
}
