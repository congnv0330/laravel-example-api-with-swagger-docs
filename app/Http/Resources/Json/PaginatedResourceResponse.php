<?php

namespace App\Http\Resources\Json;

use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Support\Arr;

class PaginatedResourceResponse extends \Illuminate\Http\Resources\Json\PaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request): array
    {
        $instance = $this->resource->resource;

        $paginated = $instance->toArray();

        $meta = $this->meta($paginated);

        if ($instance instanceof AbstractCursorPaginator) {
            $meta = array_merge($meta, [
                'cursor' => $instance->nextCursor()?->encode()
            ]);
        }

        return [
            'meta' => $meta
        ];
    }

    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function meta($paginated): array
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
            'links',
            'path'
        ]);
    }
}
