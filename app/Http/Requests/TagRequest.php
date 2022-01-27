<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 /**
 *  @OA\Schema(
 *      schema="TagRequest",
 *      title="Tag body request",
 * 	    @OA\Property(property="name", type="string", example="example"),
 *      @OA\Property(property="slug", type="string", example="", nullable="true"),
 *      @OA\Property(property="sort_order", type="integer", example="1", minimum="1", nullable="true")
 * )
 */
class TagRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'unique:slugs,value'],
            'sort_order' => ['nullable', 'integer', 'min:1']
        ];
    }
}
