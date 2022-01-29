<?php

namespace App\Services;

use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\TagResource;
use App\Models\Blog;
use App\Models\Slug;
use App\Models\Tag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SlugService
{
    public function show(string $slug): TagResource|BlogDetailResource
    {
        $slug = Slug::where('value', $slug)->firstOrFail();

        $reference = $slug->reference;

        if ($reference instanceof Tag) {
            return new TagResource($reference);
        }

        if ($reference instanceof Blog) {
            return new BlogDetailResource($reference);
        }

        throw new NotFoundHttpException();
    }
}
