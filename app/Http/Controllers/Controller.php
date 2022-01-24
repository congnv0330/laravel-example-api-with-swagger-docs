<?php

 /**
 * @OA\Info(
 *  version="1.0",
 *  title="Laravel api",
 *  description="Example for laravel api"
 * )
 * @OA\Server(
 *  url="http://localhost/api",
 *  description="Developer server"
 * )
 * @OA\Server(
 *  url="http://example-domain/api",
 *  description="Production server"
 * )
 * @OA\Tag(
 *  name="Blog",
 *  description="Everything about blogs"
 * )
 */
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
