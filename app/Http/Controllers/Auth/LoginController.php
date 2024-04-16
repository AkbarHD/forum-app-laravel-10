<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('pages.auth.login');
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();
        // dd($credentials);
        if (Auth::attempt($credentials)) { // otomatis mencocokan ke database
            return redirect()->route('discussions.index');
        }

        return redirect()->back()->withInput()->withErrors([
            'errors' => 'Email or Password Salah'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
