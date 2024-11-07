<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index() {
        $data = Option::where(function ($query) {
            if (!empty(request(key: 'equipment'))) {
                $query->where('equipment', 'LIKE', '%' . request('equipment') . '%');
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))
        ->paginate(env('APP_PAGINATION_COUNT'));
        return view('option.index', compact('data'));
    }

    public function create() {
        $services = Service::all();
        return view('option.form', compact('services'));
    }

    public function store(OptionRequest $request) {
        $option = Option::create($request->validated());
        if ($request->has('services')) {
            $option->services()->attach($request->input('services'));
        }
        return redirect(route('option.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Option $option) {
        $services = Service::all();
        return view('option.form', compact('option', 'services'));
    }

    public function update(OptionRequest $request, Option $option) {
        $option->update($request->validated());
        $option->services()->sync($request->input('services', []));
        return redirect(route('option.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Option $option) {
        $option->services()->detach();
        $option->delete();
        return redirect(route('option.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
