<?php

namespace App\Http\Controllers;

use App\Http\Requests\discussions\StoreRequest;
use App\Http\Requests\discussions\UpdateRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $discussions = Discussion::with(['User', 'Category']);

        if ($request->search) {
            // ini tdk di kasih paginate krn kalau di kasih itu error dan dia sudah otomatis mengiktu discussions yg bwh
            $discussions = $discussions->where('title', 'like', "%$request->search%")->orWhere('content', 'like', "%$request->search%")->latest();
        }

        return response()->view('pages.discussions.index', [
            // tampilkan isi discussion filter desc berdsarkan created_at dan batasi 10
            'discussions' => $discussions->orderBy('created_at', 'desc')->paginate(10)->withQueryString(), // ini harus samakan dengan yg di category controller
            'categories'  => Category::all(),
            'search' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return response()->view('pages.discussions.form', [
        //     'categories' => Category::all(),
        // ]);
        return response()->view('pages.discussions.form', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        // cari kategori brdsrkan slug, slug yg dipilih user -> dptkan 1 row -> ambil id saja 
        $category_id = Category::where('slug', $validated['category_slug'])->first()->id;
        $validated['category_id'] = $category_id;
        $validated['user_id'] =  auth()->id(); // bgsnya laravel itu lngsung bs ambil user tanpa ambil apapun
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();

        $striptContent = strip_tags($validated['content']); // ambil isi content dari form discussions
        $isContentLong = strlen($striptContent) > 120; // cek apakah isi dari content tersebut lbh dari 120?
        $validated['content_preview'] = $isContentLong ? (substr($striptContent, 0, 120) . '...') : $striptContent; // jika iya maka batasi sampai 120 karakter jika tidak maka tulis biasa saja
        $create = Discussion::create($validated);

        // dd($request->all());

        if ($create) {
            session()->flash('notif.success', 'Discussion created successfully!');
            return redirect()->route('discussions.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $discussion = Discussion::with(['User', 'Category'])->where('slug', $slug)->first();
        $discussionAnswers = Answer::where('discussion_id', $discussion->id)
            ->orderBy('created_at', 'desc')->paginate(5);

        if (!$discussion) { // ini utk url 
            return abort(404);
        }

        $notLikedImage = url('assets/images/like.png');
        $likedImage = url('assets/images/liked.png');

        return response()->view('pages.discussions.show', [
            'discussion' => $discussion, // utk mengihtung total brp answer berdasarkan slug
            'categories' => Category::all(),
            'likedImage' => $likedImage,
            'notLikedImage' => $notLikedImage,
            'discussionAnswers' => $discussionAnswers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        // jd studi kasus ini form edit dan form create itu di jadikan 1 
        $discussion = Discussion::with('Category')->where('slug', $slug)->first();

        if (!$discussion) { //jd gini,  jika url salah itu akan muncul error maka kita bikin kaya gini 
            return abort(404);
        }

        $isOwnedByUser = $discussion->user_id == auth()->id();

        if (!$isOwnedByUser) {  // penjagaan jika, bukan user asli yg masuk
            return abort(404);
        }

        return response()->view('pages.discussions.form', [
            'discussion' => $discussion,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $slug)
    {
        $discussion = Discussion::with('Category')->where('slug', $slug)->first();

        if (!$discussion) { //jd gini,  jika url salah itu akan muncul error maka kita bikin kaya gini 
            return abort(404);
        }

        $isOwnedByUser = $discussion->user_id == auth()->id();

        if (!$isOwnedByUser) {  // penjagaan jika, bukan user asli yg masuk
            return abort(404);
        }

        $validated = $request->validated();
        // cari kategori brdsrkan slug, slug yg dipilih user -> dptkan 1 row -> ambil id saja 
        $category_id = Category::where('slug', $validated['category_slug'])->first()->id;
        $validated['category_id'] = $category_id;
        $validated['user_id'] =  auth()->id(); // bgsnya laravel itu lngsung bs ambil user tanpa ambil apapun
        // field slug tdk kita update

        $striptContent = strip_tags($validated['content']); // ambil isi content dari form discussions
        $isContentLong = strlen($striptContent) > 120; // cek apakah isi dari content tersebut lbh dari 120?
        $validated['content_preview'] = $isContentLong ? (substr($striptContent, 0, 120) . '...') : $striptContent; // jika iya maka batasi sampai 120 karakter jika tidak maka tulis biasa saja

        // kayanya kalo emg first harus seperti ini dan resiko update tdk berdasakan id mungkin ini bedanya
        $update =  Discussion::with('Category')->where('slug', $slug)->first()->update($validated);


        // dd($request->all());

        if ($update) {
            session()->flash('notif.success', 'Discussion updated successfully!');
            return redirect()->route('discussions.show', $slug);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $discussion = Discussion::with('Category')->where('slug', $slug)->first();

        if (!$discussion) {
            return abort(404);
        }

        $isOwnedByUser = $discussion->user_id == auth()->id();
        if (!$isOwnedByUser) {
            return abort(404);
        }

        $delete = $discussion->delete();
        if ($delete) {
            session()->flash('notif.success', 'Discussion Deleted Successfully ');
            return redirect()->route('discussions.index');
        }

        // jika gagal deletenya, ini hanya penjagaan aja
        return abort(500);
    }
}
