<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedService
{
    protected Hasher $hasher;

    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Authenticate request
     *
     * @param LoginRequest $request
     * @return User
     */
    public function authenticate(LoginRequest $request): User
    {
        $this->ensureIsNotRateLimited($request);

        $user = User::where($request->usernameKey, $request->getUsername())->first();

        if (!$user || !$this->hasher->check($request->getPassword(), $user->password)) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'username' => __('auth.failed')
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        return $user;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(LoginRequest $request)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

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
    public function throttleKey(LoginRequest $request): string
    {
        return Str::lower($request->getUsername()) . '|' . $request->ip();
    }
}
