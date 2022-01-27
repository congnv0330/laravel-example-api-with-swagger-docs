<?php

namespace App\Services;

use App\Http\Requests\TagRequest;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TagService
{
    public function index(): TagCollection
    {
        $tags = Tag::with('slug');

        $tags = $tags->filter([
            \App\QueryFilters\SearchFilter::class,
            \App\QueryFilters\SortFilter::class
        ]);

        return new TagCollection($tags->paginate(10));
    }

    public function blogs(Tag $tag): BlogCollection
    {
        $blogs = $tag->blogs()->with([
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

        return new BlogCollection($blogs->paginate(10, Blog::columnsNoContent));
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    public function store(TagRequest $request): JsonResponse
    {
        $tag = Tag::create($request->only(['name', 'sort_order']));

        $slug = generate_slug($request->filled('slug') ? $request->post('slug') : $tag->name);

        $tag->slug()->create(['value' => $slug]);

        return response()->json(new TagResource($tag), Response::HTTP_CREATED);
    }

    public function update(Tag $tag, TagRequest $request): TagResource
    {
        $tag->fill($request->only('name', 'sort_order'));

        if ($tag->isDirty('name')) {
            $slug = generate_slug($request->filled('slug') ? $request->post('slug') : $tag->name);
            $tag->slug()->update(['value' => $slug]);
        }

        $tag->save();

        return new TagResource($tag);
    }

    public function destroy(Tag $tag): Response
    {
        $tag->delete();

        return response()->noContent();
    }
}
