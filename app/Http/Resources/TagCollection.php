<?php

namespace App\Http\Resources;

class TagCollection extends PaginationCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = TagResource::class;
}
