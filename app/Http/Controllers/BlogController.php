<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * @OA\Get(
     *  path="/blogs",
     *  summary="Get all blogs",
     *  description="Get all blogs",
     *  tags={"Blog"},
     *  @OA\Response(
     *    response=200,
     *    description="Get blog success"
     *  )
     * )
     */
    public function index()
    {
        return Blog::paginate(10);
    }
}
