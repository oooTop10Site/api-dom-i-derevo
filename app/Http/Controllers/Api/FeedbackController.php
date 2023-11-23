<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;

class FeedbackController extends ApiController
{
    public function store(FeedbackRequest $request) {
        Feedback::create($request->validated());
        return $this->outputData([], ['without_data' => __('api.message.created')]);
    }
}
