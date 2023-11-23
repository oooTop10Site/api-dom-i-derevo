<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Service\ExampleRequest;
use App\Models\Service\Example;
use Illuminate\Support\Facades\Storage;

class ExampleController extends WebController
{
    public function index() {
        $data = Example::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));
        return view('service.example.index', compact('data'));
    }

    public function create() {
        return view('service.example.form');
    }

    public function store(ExampleRequest $request) {
        $validated = $request->validated();
        $validated['image'] = request()->file('image')->store('public/service/example', ['visibility' => 'public', 'directory_visibility' => 'public']);

        Example::create($validated);
        return redirect(route('service.example.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Example $example) {
        return view('service.example.form', compact('example'));
    }

    public function update(ExampleRequest $request, Example $example) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            Storage::delete($example->image);
            $validated['image'] = request()->file('image')->store('public/service/example', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $example->update($validated);
        return redirect(route('service.example.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Example $example) {
        if ($example->services()->count() > 0) {
            return redirect(route('service.example.index', $_GET))->with('warning', __('main.alert.relationship.destroy'));
        } else {
            Storage::delete($example->image);

            $example->delete();
            return redirect(route('service.example.index', $_GET))->with('success', __('main.alert.destroy'));
        }
    }
}
