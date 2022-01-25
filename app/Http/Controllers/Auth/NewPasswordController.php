<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Services\ResetPasswordService;
use Illuminate\Http\JsonResponse;

class NewPasswordController extends Controller
{
    protected ResetPasswordService $service;

    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Post(
     *      path="/api/reset-password",
     *      summary="Reset password",
     *      description="Reset password.",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"token","email","password","password_confirmation"},
     *              @OA\Property(property="token", type="string", example="this_is_token_from_email"),
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="password", type="string", example="new_password"),
     *              @OA\Property(property="password_confirmation", type="string", example="new_password")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reset password success",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="string")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed"
     *      )
     *  )
     */
    public function update(NewPasswordRequest $request): JsonResponse
    {
        return $this->service->reset($request);
    }
}
