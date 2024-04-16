<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'answerCount' => Answer::count(),
            'discussionCount' => Discussion::count(),
            'userCount' => User::count(),
            'latestDiscussion' => Discussion::with(['Category', 'User'])->orderBy('created_at', 'desc')->limit(3)->get(),
        ]);
    }
}
