<?php

namespace App\Services;

use App\Http\Resources\BlogCollection;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BlogService
{
    public function index(): BlogCollection
    {
        $blogs = Blog::select(Blog::columnsNoContent)
            ->with([
                'slug',
                'creator',
                'updater',
                'tags' => fn ($query) => $query->with('slug')
            ]);

        $blogs = $blogs->filter([
            \App\QueryFilters\SearchFilter::class,
            \App\QueryFilters\SortFilter::class,
            \App\QueryFilters\StatusFilter::class
        ]);

        return new BlogCollection($blogs->paginate(10));
    }
}
