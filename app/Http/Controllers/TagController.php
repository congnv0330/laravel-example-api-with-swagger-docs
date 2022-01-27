<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TagController extends Controller
{
    protected TagService $service;

    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Get(
     *      path="/api/tags",
     *      summary="Get all tags",
     *      description="Get all tags",
     *      tags={"Tag"},
     *      @OA\Response(
     *          response=200,
     *          description="Get tags success",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/TagResource")
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
    public function index(): TagCollection
    {
        return $this->service->index();
    }

    /**
     *  @OA\Get(
     *      path="/api/tag/{id}",
     *      summary="Get tag",
     *      description="Get tag",
     *      tags={"Tag"},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Get tag success",
     *          @OA\JsonContent(ref="#/components/schemas/TagResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tag does not exist"
     *      )
     *  )
     */
    public function show(Tag $tag): TagResource
    {
        return $this->service->show($tag);
    }

    /**
     *  @OA\Post(
     *      path="/api/tag",
     *      summary="Create tag",
     *      description="Create tag.",
     *      tags={"Tag"},
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"name"},
     *              ref="#/components/schemas/TagRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Create tag success",
     *          @OA\JsonContent(ref="#/components/schemas/TagResource")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     *  )
     */
    public function store(TagRequest $request): JsonResponse
    {
        return $this->service->store($request);
    }

    /**
     *  @OA\Put(
     *      path="/api/tag/{id}",
     *      summary="Update tag",
     *      description="Update tag by id",
     *      tags={"Tag"},
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
     *              required={"name"},
     *              ref="#/components/schemas/TagRequest"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Update tag success",
     *          @OA\JsonContent(ref="#/components/schemas/TagResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tag does not exist"
     *      )
     *  )
     */
    public function update(TagRequest $request, Tag $tag): TagResource
    {
        return $this->service->update($tag, $request);
    }

    /**
     *  @OA\Delete(
     *      path="/api/tag/{id}",
     *      summary="Delete tag",
     *      description="Delete tag.",
     *      tags={"Tag"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Delete tag success"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Tag does not exist"
     *      )
     *  )
     */
    public function destroy(Tag $tag): Response
    {
        return $this->service->destroy($tag);
    }
}
