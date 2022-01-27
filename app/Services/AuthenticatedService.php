<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class AuthenticatedService
{
    /**
     * Authenticate request
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $throttleKey = $this->throttleKey($request);

        $this->ensureIsNotRateLimited($request, $throttleKey);

        $user = User::where('email', $request->getUsername())->first();

        if (!$user || !Hash::check($request->getPassword(), $user->password)) {
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('auth.failed')
            ]);
        }

        RateLimiter::clear($throttleKey);

        $token = $this->createToken($user);

        return response()->json([
            'token' => $token->plainTextToken
        ]);
    }

    /**
     * Generate access token
     *
     * @param User $user
     * @return NewAccessToken
     */
    protected function createToken(User $user): NewAccessToken
    {
        return $user->createToken($user->id . '_' . date('YmdHis'));
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(LoginRequest $request, string $throttleKey)
    {
        if (!RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60)
            ])
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    protected function throttleKey(LoginRequest $request): string
    {
        return Str::lower($request->getUsername()) . '|' . $request->ip();
    }
}
