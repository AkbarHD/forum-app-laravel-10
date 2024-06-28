<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\My\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// ------------------------------------ Discussions --------------------------------------------------

Route::middleware('auth')->group(function () {
    // my profile
    Route::namespace('App\Http\Controllers\My')->group(function () {
        Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
    });

    Route::namespace('App\Http\Controllers')->group(function () {
        Route::resource('discussions', DiscussionController::class)->only(['create', 'store', 'edit', 'update', 'destroy']); // jd nnt index dan show itu dluar 

        // Answer
        Route::post('discussions/{disioncuss}/answer', 'AnswerController@store')->name('discussions.answer.store');
        Route::resource('answers', AnswerController::class)->only(['edit', 'update', 'destroy']);

        // likeController discussion
        Route::post('discussions/{discussion}/like', 'LikeController@discussionLike')->name('discussions.like.like');
        Route::post('discussions/{discussion}/unlike', 'LikeController@discussionUnLike')->name('discussions.like.unlike');

        // likeController Answer
        Route::post('answers/{answer}/like', 'LikeController@answerLike')->name('answers.like.like');
        Route::post('answers/{answer}/unlike', 'LikeController@answerUnLike')->name('answers.like.unlike');
    });
});

// Route resource tapi bisa di akses tanpa login
Route::namespace('App\Http\Controllers')->group(function () {
    //Home (Halaman utama)
    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('discussions', DiscussionController::class)->only(['index', 'show']);

    // Category Controller
    Route::get('discussions/categories/{categories}', 'CategoryController@show')
        ->name('discussions.categories.show');
});

// ------------------------------------ Discussions --------------------------------------------------


// ----------- auth ------------
Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/login', 'LoginController@show')->name('auth.login.show');
    Route::post('/login', 'LoginController@login')->name('auth.login.login');
    Route::post('/logout', 'LoginController@logout')->name('auth.login.logout');
    // ---------- sign Up -------
    Route::get('/sign-up', 'SignupController@show')->name('auth.sign-up.show');
    Route::post('/sign-up', 'SignupController@signUp')->name('auth.sign-up.sign-up');
});


// ----------- end auth ------------ 

// Route::get('/', function () {
//     return view('home');
// })->name('home');

// ---------------------------------
// Route::get('/discussions', function () {
    //     return view('pages.discussions.index');
// })->name('discussions.index');
// Route::get('/discussions/lorem', function () {
//     return view('pages.discussions.show');
// })->name('discussions.show');

// Route::get('/discussions/create', function () {
//     return view('pages.discussions.form');
// })->name('discussions.create');

// Route::get('/answers/1', function () {
//     return view('pages.answers.form');
// })->name('answer.edit');


// -------------------users------------
// Route::namespace('App\Http\Controllers\My')->group(function () {
//     Route::resource('users', UserController::class)->only(['show']);
// });
// Route::get('/users/akbar', function () {
//     return view('pages.users.show');
// })->name('users.show');
