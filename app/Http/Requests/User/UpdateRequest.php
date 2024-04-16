<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;  // import Rule
use Illuminate\Validation\Rules\Password; // Import Password

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required', 'alpha_dash', Rule::unique('users')->ignore(request()->username, 'username'), 'min:3', 'max:50'
            ],
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'confirm-password' => ['nullable'],
            'picture' => ['nullable', 'image', 'max:1500'],
        ];
    }
}
