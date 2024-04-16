<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    public function show()
    {
        return view('pages.auth.sign-up');
    }

    public function signUp(SignUpRequest $request)
    {
        $validated =  $request->validated();

        // dsni knp usernanem tdk di otak atik? karna sdh di tamung dgn $validated

        $validated['password'] = bcrypt($validated['password']);
        $validated['picture'] = config('app.avatar_generator_url') . $validated['username'];

        // studi kasusnya ini jika signupnya berhasil maka langsung di loginkan dan masuk ke discussion
        $create = User::create($validated);

        if ($create) { // jika berhasil maka loginkan
            Auth::login($create);
            return redirect()->route('discussions.index'); // dia sdh otomatis di loginkan
        }

        return abort(500); // jika gagal
    }
}
