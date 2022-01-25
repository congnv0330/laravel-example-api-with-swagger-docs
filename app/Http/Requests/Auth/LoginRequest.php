<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Username key
     *
     * @var string
     */
    public string $usernameKey = 'email';

    /**
     * Password key
     *
     * @var string
     */
    public string $passwordKey = 'password';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            $this->usernameKey => ['required', 'string'],
            $this->passwordKey => ['required', 'string']
        ];
    }

    public function getUsername(): string
    {
        return $this->post($this->usernameKey);
    }

    public function getPassword(): string
    {
        return $this->post($this->passwordKey);
    }
}
