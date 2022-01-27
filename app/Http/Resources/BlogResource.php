<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

 /**
 *  @OA\Schema(
 *      schema="BlogResource",
 *      title="Blog json response",
 * 	    @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="description", type="string"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="thumbnail_image", type="string"),
 *      @OA\Property(property="cover_image", type="string"),
 *      @OA\Property(property="sort_order", type="integer"),
 *      @OA\Property(
 *          property="creator",
 *          type="object",
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="name", type="string"),
 *          @OA\Property(property="email", type="string")
 *      ),
 *      @OA\Property(
 *          property="updater",
 *          type="object",
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="name", type="string"),
 *          @OA\Property(property="email", type="string")
 *      ),
 *      @OA\Property(
 *          property="tags",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/TagResource")
 *      ),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug?->value,
            'thumbnail_image' => $this->thumbnail_image,
            'cover_image' => $this->cover_image,
            'sort_order' => $this->sort_order,
            'creator' => $this->creator,
            'updater' => $this->updater,
            'tags' => new TagCollection($this->tags),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
