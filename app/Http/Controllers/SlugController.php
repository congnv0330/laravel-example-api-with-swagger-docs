<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\TagResource;
use App\Services\SlugService;

class SlugController extends Controller
{
    protected SlugService $service;

    public function __construct(SlugService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Get(
     *      path="/api/slug/{slug}",
     *      summary="Get blog or tag",
     *      description="Get blog or tag by slug",
     *      tags={"Slug"},
     *      @OA\Parameter(
     *          in="path",
     *          name="slug",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Get blog or tag success",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/TagResource"),
     *                  @OA\Schema(ref="#/components/schemas/BlogDetailResource")
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blog or tag does not exist"
     *      )
     *  )
     */
    public function show(string $slug): TagResource|BlogDetailResource
    {
        return $this->service->show($slug);
    }
}
