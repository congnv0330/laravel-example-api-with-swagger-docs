<?php

namespace App\Http\Resources;

class BlogCollection extends PaginationCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = BlogResource::class;
}
