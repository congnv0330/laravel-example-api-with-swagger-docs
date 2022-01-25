<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetLinkRequest;
use App\Services\ResetPasswordService;
use Illuminate\Http\JsonResponse;

class PasswordResetLinkController extends Controller
{
    protected ResetPasswordService $service;

    public function __construct(ResetPasswordService $service)
    {
        $this->service = $service;
    }

    /**
     *  @OA\Post(
     *      path="/api/forgot-password",
     *      summary="Forgot password",
     *      description="Send reset password link.",
     *      tags={"Authentication"},
     *      @OA\RequestBody(
     *          required=true,
     *          description="Parameters",
     *          @OA\JsonContent(
     *              required={"email"},
     *              @OA\Property(property="email", type="string", example="example@gmail.com")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Send reset link success",
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
    public function sendResetLink(PasswordResetLinkRequest $request): JsonResponse
    {
        return $this->service->sendResetLink($request->post('email'));
    }
}
