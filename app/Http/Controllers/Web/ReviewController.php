<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Service\Category;

class ReviewController extends WebController
{
    public function index() {
        $data = Review::where(function ($query) {
            if (!empty(request('author'))) {
                $query->where('author', 'LIKE', '%' . request('author') . '%');
            }

            if (!empty(request('date_available'))) {
                $query->where('date_available', date('Y-m-d', strtotime(request('date_available'))));
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('review.index', compact('data'));
    }

    public function create() {
        $categories = Category::whereNull('category_id')->get();
        return view('review.form', compact('categories'));
    }

    public function store(ReviewRequest $request) {
        Review::create($request->validated());
        return redirect(route('review.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Review $review) {
        $categories = Category::whereNull('category_id')->get();
        return view('review.form', compact('review', 'categories'));
    }

    public function update(ReviewRequest $request, Review $review) {
        $review->update($request->validated());
        return redirect(route('review.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Review $review) {
        $review->delete();
        return redirect(route('review.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
