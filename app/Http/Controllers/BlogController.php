<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogDetailResource;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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

    /**
     *  @OA\Get(
     *      path="/api/blog/{id}",
     *      summary="Get blog",
     *      description="Get blog",
     *      tags={"Blog"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Get blog success",
     *          @OA\JsonContent(ref="#/components/schemas/BlogDetailResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blog does not exist"
     *      )
     *  )
     */
    public function show(Blog $blog): BlogDetailResource
    {
        return $this->service->show($blog);
    }

    /**
     *  @OA\Post(
     *      path="/api/blog",
     *      summary="Create blog",
     *      description="Create blog.",
     *      tags={"Blog"},
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"title", "description", "content", "tags"},
     *              ref="#/components/schemas/BlogRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Create blog success",
     *          @OA\JsonContent(ref="#/components/schemas/BlogDetailResource")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     *  )
     */
    public function store(BlogRequest $request): JsonResponse
    {
        return $this->service->store($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/blog/{id}",
     *      summary="Update blog",
     *      description="Update blog by id",
     *      tags={"Blog"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"title", "description", "content", "tags"},
     *              ref="#/components/schemas/BlogRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Update blog success",
     *          @OA\JsonContent(ref="#/components/schemas/BlogDetailResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blog does not exist"
     *      )
     *  )
     */
    public function update(BlogRequest $request, Blog $blog): BlogDetailResource
    {
        return $this->service->update($blog, $request);
    }

    /**
     *  @OA\Delete(
     *      path="/api/blog/{id}",
     *      summary="Delete blog",
     *      description="Delete blog.",
     *      tags={"Blog"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Delete blog success"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Blog does not exist"
     *      )
     *  )
     */
    public function destroy(Blog $blog): Response
    {
        return $this->service->destroy($blog);
    }
}
