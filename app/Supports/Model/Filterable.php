<?php

namespace App\Supports\Model;

use Closure;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(
        Builder $query,
        array $through,
        Closure|null $callback = null
    ): Builder {
        $pipeline =  app(Pipeline::class)
            ->send($query)
            ->through($through);

        if (is_callable($callback)) {
            return $pipeline->then($callback);
        }

        return $pipeline->thenReturn();
    }
}
