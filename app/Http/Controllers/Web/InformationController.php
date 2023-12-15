<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\InformationRequest;
use App\Models\Information;

class InformationController extends WebController
{
    public function index() {
        $data = Information::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('information.index', compact('data'));
    }

    public function create() {
        return view('information.form');
    }

    public function store(InformationRequest $request) {
        $validated = $request->validated();
        Information::create($validated);
        return redirect(route('information.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Information $information) {
        return view('information.form', compact('information'));
    }

    public function update(InformationRequest $request, Information $information) {
        $validated = $request->validated();
        $information->update($validated);
        return redirect(route('information.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Information $information) {
        $information->delete();
        return redirect(route('information.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
