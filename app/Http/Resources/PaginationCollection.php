<?php

namespace App\Http\Resources;

use App\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

 /**
 *  @OA\Schema(
 *      schema="PaginationCollection",
 *      title="Paginate json response",
 *      @OA\Property(property="current_page", type="integer"),
 *      @OA\Property(property="from", type="integer"),
 *      @OA\Property(property="last_page", type="integer"),
 *      @OA\Property(property="per_page", type="integer"),
 *      @OA\Property(property="to", type="integer"),
 *      @OA\Property(property="total", type="integer")
 * )
 */
class PaginationCollection extends ResourceCollection
{
    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }
}
