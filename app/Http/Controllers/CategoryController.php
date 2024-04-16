<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return abort(404); // ini sbnrnya utk penjagaan aja sih, jika category tdk ditemukan
        }

        $discussions = Discussion::with(['User', 'Category'])
            ->where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return response()->view('pages.discussions.index', [
            'discussions' => $discussions, // ini harus samakan dengan yang ada di discussions
            'categories' => Category::all(),
            'withCategory' => $category,
        ]);
    }
}
