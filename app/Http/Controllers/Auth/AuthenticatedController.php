<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthenticatedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    protected AuthenticatedService $service;

    public function __construct(AuthenticatedService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Post(
     *      path="/api/login",
     *      summary="Login",
     *      description="Authenticate the request's credentials.",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="password", type="string", example="password")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login success",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     *  )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->service->login($request);
    }

    /**
     *  @OA\Get(
     *      path="/api/me",
     *      summary="Get auth user",
     *      description="Get authenticate user base on token.",
     *      tags={"Authentication"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Get user information success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="email_verified_at", type="string", format="date-time"),
     *              @OA\Property(property="created_at", type="string", format="date-time"),
     *              @OA\Property(property="updated_at", type="string", format="date-time")
     *          )
     *      )
     *  )
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
