<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginationCollection;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/blogs",
     *  summary="Get all blogs",
     *  description="Get all blogs",
     *  tags={"Blog"},
     *  @OA\Response(
     *    response=200,
     *    description="Get blog success"
     *  )
     * )
     */
    public function index(): PaginationCollection
    {
        return new PaginationCollection(Blog::paginate(10));
    }
}
