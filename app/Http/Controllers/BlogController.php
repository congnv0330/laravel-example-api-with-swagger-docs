<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCollection;
use App\Services\BlogService;

class BlogController extends Controller
{
    protected BlogService $service;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Get(
     *      path="/api/blogs",
     *      summary="Get all blogs",
     *      description="Get all blogs",
     *      tags={"Blog"},
     *      @OA\Parameter(
     *          in="query",
     *          name="page",
     *          description="Default page 1",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          name="q",
     *          description="Search",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          name="status",
     *          description="0 - DRAFT, 1 - PUBLISHED, 2 - ARCHIVED. Default 1",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          name="sort[0][]",
     *          description="Multi sort",
     *          @OA\Schema(
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(type="string"),
     *              example={"id", "desc"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Get blogs success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/BlogResource")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  ref="#/components/schemas/PaginationCollection"
     *              )
     *          )
     *      )
     *  )
     */
    public function index(): BlogCollection
    {
        return $this->service->index();
    }
}
