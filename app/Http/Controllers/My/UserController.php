<?php

namespace App\Http\Controllers\My;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Answer;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($username)
    {
        // get berdasarkan username
        // cek apakah user dengan username tersebut ada
        // jika tdk ada, maka return page not found
        //buat var picture, bikin conditional
        // cek apakah picture ini url, kalau iya maka tampilkan langsung, kalau tdk tampilkan dengan facade storage
        // get discussion berdasarkan id user dan get pagination per 5
        // get answer berdasarkan id user dan get pagination per 5
        // return view

        $user = User::where('username', $username)->first();
        if (!$user) {
            return abort(404);
        }

        $picture = filter_var($user->picture, FILTER_VALIDATE_URL) ? $user->picture : Storage::url($user->picture);

        // utk mengatasi 2 paginate dalam 1 pages
        $perPage = 5;
        $columns = ['*'];
        $discussionsPageName = 'discussions';
        $answersPageName = 'answers';

        return view('pages.users.show', [
            'user' => $user,
            'picture' => $picture,
            'discussions' => Discussion::with(['Category', 'User'])->where('user_id', $user->id)->paginate($perPage, $columns, $discussionsPageName),
            'answers' => Answer::with('discussion')->where('user_id', $user->id)->paginate($perPage, $columns, $answersPageName),
        ]);
    }

    public function edit($username)
    {
        // kita edit bkn berdasarkan edit atau id, tp berdsarkan username
        // get berdasarkan username
        // pencegahan jika user tdk ada atau user id tdk sama dgn id milik user yg sdg login
        // maka return page not found
        // return view

        $user = User::where('username', $username)->first();
        if (!$user || $user->id !== auth()->id()) {
            return abort(404);
        }
        $picture = filter_var($user->picture, FILTER_VALIDATE_URL) ? $user->picture : Storage::url($user->picture);

        return view('pages.users.form', [
            'user' => $user,
            'picture' => $picture
        ]);
    }

    public function update(UpdateRequest $request, $username)
    {
        // get user brdsrkan username
        // cek jika user tdk ada atau user id tdk sm dgn id milik user yg sdg login
        // maka return page not found
        // get request yg tervalidasi
        // cek apakah password diisi
        // jika iya maka nilainya di biarkan dan hash password tsb
        // jika tdk maka hapus password di validated
        // cek apakah nilai picture tdk kosong
        // jika iya maka
        // cek apakah nilai picture di tabel itu bukan url
        // jika bukan maka hapus dlu picture tsb dari disk storage kita
        // masukan url tsb ke variabel validated
        // upodate record
        // jika update berhasil maka kirim notif success dan redirect ke user profile kita]
        // jika tdk maka abort 500


        $user = User::where('username', $username)->first();
        if (!$user || $user->id !== auth()->id()) {
            return abort(404);
        }

        $validated = $request->validated();

        if (isset($validated['password'])) { // jika passsword diisi
            $validated['password'] = bcrypt($validated['password']); // maka field password database hash kan
        } else { // jika tdk maka harus di unset agar tdk di ambil oleh validated
            unset($validated['password']);
        }

        // jika ganti gambar
        if ($request->hasFile('picture')) {
            // dan jika gambar ini bukan url
            if (filter_var($user->picture, FILTER_VALIDATE_URL) === false) {
                Storage::disk('public')->delete($user->picture);
            }

            $filePath = Storage::disk('public')->put('images/users/picture', request()->file('picture'));
            $validated['picture'] = $filePath;
        }

        $update = $user->update($validated);

        if ($update) {
            session()->flash('notif.success', 'User profile updated successfully');
            return redirect()->route('users.show', $validated['username']);
        }
    }
}
