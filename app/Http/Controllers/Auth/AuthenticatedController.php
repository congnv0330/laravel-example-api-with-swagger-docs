<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthenticatedService;

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
     *              @OA\Property(property="password", type="string", example="12345")
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
    public function login(LoginRequest $request)
    {
        $user = $this->service->authenticate($request);

        $token = $user->createToken($user->id . '-' . date('YmdHis'));

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }
}
