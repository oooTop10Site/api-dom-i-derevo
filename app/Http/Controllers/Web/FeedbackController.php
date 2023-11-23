<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;

class FeedbackController extends WebController
{
    public function index() {
        $data = Feedback::where(function ($query) {
            if (!empty(request('author'))) {
                $query->where('author', 'LIKE', '%' . request('author') . '%');
            }

            if (!empty(request('created_at'))) {
                $query->where('created_at', date('Y-m-d', strtotime(request('created_at'))));
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('feedback.index', compact('data'));
    }

    public function create() {
        return view('feedback.form');
    }

    public function store(FeedbackRequest $request) {
        Feedback::create($request->validated());
        return redirect(route('feedback.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Feedback $feedback) {
        return view('feedback.form', compact('feedback'));
    }

    public function update(FeedbackRequest $request, Feedback $feedback) {
        $feedback->update($request->validated());
        return redirect(route('feedback.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Feedback $feedback) {
        $feedback->delete();
        return redirect(route('feedback.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
