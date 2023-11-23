<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Service\CategoryRequest;
use App\Models\Service\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends WebController
{
    public function index() {
        $data = Category::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('category'))) {
                $query->where('category_id', request('category'));
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));

        $data = $this->get_parents($data);
        $categories = $this->get_parents();

        return view('service.category.index', compact('data', 'categories'));
    }

    public function create() {
        $categories = $this->get_parents();
        return view('service.category.form', compact('categories'));
    }

    public function store(CategoryRequest $request) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            $validated['image'] = request()->file('image')->store('public/service/category', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        Category::create($validated);
        return redirect(route('service.category.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Category $category) {
        $categories = $this->get_parents(Category::where('id', '!=', $category->id)->get(), $category->id);
        return view('service.category.form', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, Category $category) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            if (!empty($category->image)) {
                Storage::delete($category->image);
            }

            $validated['image'] = request()->file('image')->store('public/service/category', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $category->update($validated);
        return redirect(route('service.category.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Category $category) {
         if ($category->categories()->count() > 0) {
             return redirect(route('service.category.index', $_GET))->with('warning', __('main.alert.relationship.destroy'));
         } else {
            if (!empty($category->image)) {
                Storage::delete($category->image);
            }

            $category->delete();
            return redirect(route('service.category.index', $_GET))->with('success', __('main.alert.destroy'));
         }
    }
}
