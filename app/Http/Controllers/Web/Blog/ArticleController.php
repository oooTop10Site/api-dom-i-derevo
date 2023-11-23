<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Blog\ArticleRequest;
use App\Models\Blog\Article;
use App\Models\Blog\Category;
use Illuminate\Support\Facades\Storage;

class ArticleController extends WebController
{
    public function index() {
        $categories = Category::all();
        $data = Article::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('category'))) {
                $query->where('category_id', request('category'));
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->with('category')->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('blog.article.index', compact('data', 'categories'));
    }

    public function create() {
        $categories = Category::all();
        return view('blog.article.form', compact('categories'));
    }

    public function store(ArticleRequest $request) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            $validated['image'] = request()->file('image')->store('public/blog/article', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        Article::create($validated);
        return redirect(route('blog.article.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Article $article) {
        $categories = Category::all();
        return view('blog.article.form', compact('article', 'categories'));
    }

    public function update(ArticleRequest $request, Article $article) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            if (!empty($article->image)) {
                Storage::delete($article->image);
            }

            $validated['image'] = request()->file('image')->store('public/blog/article', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $article->update($validated);
        return redirect(route('blog.article.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Article $article) {
        if (!empty($article->image)) {
            Storage::delete($article->image);
        }

        $article->delete();
        return redirect(route('blog.article.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
