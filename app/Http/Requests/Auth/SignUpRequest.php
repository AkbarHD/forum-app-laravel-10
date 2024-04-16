<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password; // import password

class SignUpRequest extends FormRequest
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
            'email' => 'required|email|unique:App\Models\User,email|min:8|max:50', // ini trnyata bs di mnggnkn models
            // mixedCase = ada huruf kecil & bsr, numbers = harus ada angka, symbols = harus ada symbols, cth = P@assw0rd
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'username' => 'required|alpha_dash|unique:App\Models\User,username|min:3|max:50',
        ];
    }
}
