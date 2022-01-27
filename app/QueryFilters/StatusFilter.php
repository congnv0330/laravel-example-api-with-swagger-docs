<?php

namespace App\QueryFilters;

use Closure;
use App\Enums\StatusEnum;
use App\Exceptions\UnknownStatusException;
use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends Filter
{
    public function handle(Builder $query, Closure $next)
    {
        $status = $this->request->query('status', StatusEnum::PUBLISHED->value);

        if (!StatusEnum::tryFrom($status)) {
            throw new UnknownStatusException();
        }

        $query = $query->where('status', $status);

        return $next($query);
    }
}
