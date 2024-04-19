<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Service\ServiceRequest;
use App\Models\Service\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends WebController
{
    public function index() {
        $data = Service::where(function ($query) {
            if (!empty(request('name'))) {
                $query->where('name', 'LIKE', '%' . request('name') . '%');
            }

            if (!empty(request('category'))) {
                $query->whereHas('relationship_category', function ($query) {
                    $query->where('category_id', request('category'));
                });
            }

            if (!empty(request('status')) || request('status') === '0') {
                $query->where('status', request('status'));
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))->paginate(env('APP_PAGINATION_COUNT'));

        $categories = $this->get_parents();

        return view('service.index', compact('data', 'categories'));
    }

    public function create() {
        $categories = $this->get_parents();

        $services = Service::all();
        return view('service.form', compact('categories', 'services'));
    }

    public function store(ServiceRequest $request) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            $validated['image'] = request()->file('image')->store('public/service', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $validated['price'] = json_encode($validated['price']);
        if (!empty(request('additional_info'))) {
            $validated['additional_info'] = json_encode($validated['additional_info']);
        }

        $service = Service::create($validated);
        if (!empty($validated['categories']) && count($validated['categories']) > 0) {
            $service->relationship_category()->createMany($validated['categories']);
        }
        if (!empty($validated['services']) && count($validated['services']) > 0) {
            $service->relationship_service()->createMany($validated['services']);
        }

        return redirect(route('service.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Service $service) {
        $categories = $this->get_parents();
        $services = Service::where('id', '!=', $service->id)->get();

        $service->price = json_decode($service->price);
        $service->additional_info = json_decode($service->additional_info);

        return view('service.form', compact('service', 'categories', 'services'));
    }

    public function update(ServiceRequest $request, Service $service) {
        $validated = $request->validated();

        if (request()->hasFile('image')) {
            if (!empty($article->image)) {
                Storage::delete($article->image);
            }

            $validated['image'] = request()->file('image')->store('public/service', ['visibility' => 'public', 'directory_visibility' => 'public']);
        }

        $validated['price'] = json_encode($validated['price']);
        if (!empty(request('additional_info'))) {
            $validated['additional_info'] = json_encode($validated['additional_info']);
        }

        $service->update($validated);
        if (!empty($validated['categories']) && count($validated['categories']) > 0) {
            $service->relationship_category()->delete();
            $service->relationship_category()->createMany($validated['categories']);
        }
        if (!empty($validated['services']) && count($validated['services']) > 0) {
            $service->relationship_service()->delete();
            $service->relationship_service()->createMany($validated['services']);
        }

        return redirect(route('service.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Service $service) {
        if (!empty($service->image)) {
            Storage::delete($service->image);
        }

        $service->relationship_category()->delete();
        $service->relationship_service()->delete();
        $service->delete();

        return redirect(route('service.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
