<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Blog\CategoryRequest;
use App\Models\Blog\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends WebController
{
    public function index() {
        $data = Category::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('blog.category.index', compact('data'));
    }

    public function create() {
        return view('blog.category.form');
    }

    public function store(CategoryRequest $request) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            $validated['image'] = request()->file('image')->store('public/blog/category', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        Category::create($validated);
        return redirect(route('blog.category.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Category $category) {
        return view('blog.category.form', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            if (!empty($category->image)) {
                Storage::delete($category->image);
            }

            $validated['image'] = request()->file('image')->store('public/blog/category', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $category->update($validated);
        return redirect(route('blog.category.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Category $category) {
        if ($category->articles()->count() > 0) {
            return redirect(route('blog.category.index', $_GET))->with('warning', __('main.alert.relationship.destroy'));
        } else {
            if (!empty($category->image)) {
                Storage::delete($category->image);
            }

            $category->delete();
            return redirect(route('blog.category.index', $_GET))->with('success', __('main.alert.destroy'));
        }
    }
}
