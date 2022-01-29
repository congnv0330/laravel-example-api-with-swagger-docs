<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Services\UploadService;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    protected UploadService $service;

    public function __construct(UploadService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *      path="/api/upload/image",
     *      summary="Upload file image",
     *      description="Upload file image.",
     *      tags={"Utilities"},
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="file",
     *                      type="file"
     *                  ),
     *                  required={"file"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Upload success",
     *          @OA\JsonContent(
     *              @OA\Property(property="path", type="string"),
     *              @OA\Property(property="url", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     *  )
     */
    public function uploadImage(UploadImageRequest $request): JsonResponse
    {
        return $this->service->upload($request->file('file'));
    }
}
