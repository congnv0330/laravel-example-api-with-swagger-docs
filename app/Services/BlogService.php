<?php

namespace App\Services;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogDetailResource;
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

    public function show(Blog $blog): BlogDetailResource
    {
        return new BlogDetailResource($blog);
    }

    public function store(BlogRequest $request): JsonResponse
    {
        $blog = Blog::create($request->only([
            'title',
            'description',
            'content',
            'thumbnail_image',
            'cover_image',
            'sort_order',
            'status'
        ]));

        $slug = $request->filled('slug')
            ? $request->post('slug')
            : generate_slug($blog->title);

        $blog->slug()->create(['value' => $slug]);

        $blog->tags()->attach($request->post('tags', []));

        return response()->json(new BlogDetailResource($blog), Response::HTTP_CREATED);
    }

    public function update(Blog $blog, BlogRequest $request)
    {
        $blog->fill($request->only([
            'title',
            'description',
            'content',
            'thumbnail_image',
            'cover_image',
            'sort_order',
            'status'
        ]));

        if ($blog->isDirty('title')) {
            $slug = $request->filled('slug')
                ? $request->post('slug')
                : generate_slug($blog->title);

            $blog->slug()->update(['value' => $slug]);
        }

        $blog->save();

        $blog->tags()->sync($request->post('tags'));

        return new BlogDetailResource($blog);
    }

    public function destroy(Blog $blog): Response
    {
        $blog->delete();

        return response()->noContent();
    }
}
