<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Discussion;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // pluglin like ini menggunakan ajax
    public function discussionLike(string $discussionSlug)
    {
        // utk menampung like
        $discussion = Discussion::where('slug', $discussionSlug)->first();

        $discussion->like(); // bwaan dari plugin

        return response()->json([
            'status' => 'success',
            'data' => [
                'likeCount' => $discussion->likeCount, // bwaan dari plugin
            ],
        ]);
    }
    public function discussionUnLike(string $discussionSlug)
    {
        $discussion = Discussion::where('slug', $discussionSlug)->first();

        $discussion->unlike(); // bwaan dari plugin

        return response()->json([
            'status' => 'success',
            'data' => [
                'likeCount' => $discussion->likeCount, // bwaan dari plugin
            ]
        ]);
    }


    // answer
    public function answerLike(string $answerId)
    {
        $answer = Answer::find($answerId);

        $answer->like();

        return response()->json([
            'status' => 'success',
            'data' => [
                'likeCount' => $answer->likeCount,
            ]
        ]);
    }

    public function answerUnLike(string $answerId)
    {
        $answer = Answer::find($answerId);

        $answer->unlike();

        return response()->json([
            'status' => 'success',
            'data' => [
                'likeCount' => $answer->likeCount,
            ]
        ]);
    }
}
