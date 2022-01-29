<?php

namespace App\Http\Requests;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

 /**
 *  @OA\Schema(
 *      schema="BlogRequest",
 *      title="Blog body request",
 * 	    @OA\Property(property="title", type="string", example="Blog example"),
 *      @OA\Property(property="slug", type="string", example="", nullable="true"),
 *      @OA\Property(property="description", type="string", example="Blog description"),
 *      @OA\Property(property="content", type="string", example="<p>Hello content</p>"),
 *      @OA\Property(property="thumbnail_image", type="string", example="", nullable="true"),
 *      @OA\Property(property="cover_image", type="string", example="", nullable="true"),
 *      @OA\Property(property="status", type="integer", example="0", nullable="true"),
 *      @OA\Property(property="sort_order", type="integer", example="1", minimum="1", nullable="true"),
 *      @OA\Property(
 *          property="tags",
 *          type="array",
 *          @OA\Items(type="integer"),
 *          example={1,2,3}
 *      )
 * )
 */
class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'unique:slugs,value'],
            'description' => ['required', 'string', 'max:255'],
            'content' => ['required'],
            'thumbnail_image' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'integer', new Enum(StatusEnum::class)],
            'tags' => ['required', 'array', 'min:1']
        ];
    }
}
