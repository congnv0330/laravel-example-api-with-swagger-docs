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
        $blogs = Blog::select([
            'id',
            'title',
            'description',
            'thumbnail_image',
            'cover_image',
            'sort_order',
            'creator_id',
            'updater_id',
            'created_at',
            'updated_at'
        ])->with('slug');

        $blogs = $blogs->filter([
            \App\QueryFilters\SearchFilter::class,
            \App\QueryFilters\SortFilter::class,
            \App\QueryFilters\StatusFilter::class
        ]);

        return new BlogCollection($blogs->paginate(10));
    }
}
