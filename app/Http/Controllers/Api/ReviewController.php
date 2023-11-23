<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;

class ReviewController extends ApiController
{
    public function index() {
        return $this->outputPaginationData(Review::where('status', true)->orderBy('sort_order', 'ASC')->paginate($this->get_limit()));
    }

    public function show(Review $review) {
        return $review->status ? $this->outputData($review) : abort(404, __('api.message.not_found'));
    }

    public function store(ReviewRequest $request) {
        $validated = $request->validated();
        $validated['date_available'] = date('Y-m-d');

        Review::create($validated);

        return $this->outputData([], ['without_data' => __('api.message.created')]);
    }
}
