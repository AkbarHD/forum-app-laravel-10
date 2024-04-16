<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\StoreRequest;
use App\Http\Requests\Answer\UpdateRequest;
use App\Models\Answer;
use App\Models\Discussion;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // method index tdk ada karena ngikut discussion show

    public function store(StoreRequest $request, $slug)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        // jadi answer ini menangkap discuss brdsrkn slug, dpt 1 row lalu ambil idnya saja
        $validated['discussion_id'] = Discussion::where('slug', $slug)->first()->id;
        $create = Answer::create($validated);

        if ($create) {
            session()->flash('notif.success', 'Your answer posted successfully');
            return redirect()->route('discussions.show', $slug);
        }

        return abort(500);
    }



    public function edit(string $id)
    {
        // get data berdasarkan id
        $answer = Answer::find($id);

        if (!$answer) {
            return abort(404);
        }

        $isOwnedByUser = $answer->user_id == auth()->id();

        if (!$isOwnedByUser) {
            return abort(404);
        }

        return response()->view('pages.answers.form', [
            'answer' => $answer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $answer = Answer::find($id);


        if (!$answer) {
            return abort(404);
        }

        $isOwnedByUser = $answer->user_id == auth()->id();
        if (!$isOwnedByUser) {
            return abort(404);
        }

        $validated = $request->validated();

        $update = $answer->update($validated);
        if ($update) {
            session()->flash('notif.success', 'Answer updated successfully');
            return redirect()->route('discussions.show',  $answer->discussion->slug);
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $answer = Answer::find($id);


        if (!$answer) {
            return abort(404);
        }

        $isOwnedByUser = $answer->user_id == auth()->id();
        if (!$isOwnedByUser) {
            return abort(404);
        }


        $delete = $answer->delete();
        if ($delete) {
            session()->flash('notif.success', 'Answer Deleted successfully');
            return redirect()->route('discussions.show',  $answer->discussion->slug);
        }

        return abort(500);
    }
}
