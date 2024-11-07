<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\Service\ServiceRequest;
use App\Models\Service\Service;
use App\Models\Service\ServiceImage;
use App\Models\Service\Video;
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
        if (!empty(request()->file('images')) && count(request()->file('images')) > 0) {
            $validated['images'] = [];

            foreach (request()->file('images') as $key => $image) {
                if (!empty($image['image'])) {
                    $validated['images'][] = [
                        'image' => $image['image']->store('public/service/' . $service->id, ['visibility' => 'public', 'directory_visibility' => 'public']),
                        'sort_order' => request('images.' . $key . '.sort_order', 0),
                    ];
                }
            }

            $service->relationship_image()->createMany($validated['images']);
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                // Сохраняем видео файл
                $path = $videoFile->store('images', 'public'); 

                $video = Video::create([
                    'path' => $path,
                    // 'service_id' => $service->id, 
                ]);

                $service->videos()->attach($video->id);
            }
        }

        return redirect(route('service.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Service $service) {
        $categories = $this->get_parents();
        $services = Service::where('id', '!=', $service->id)->get();
        $images = ServiceImage::where('service_id', $service->id)->get();

        $service->price = json_decode($service->price);
        $service->additional_info = json_decode($service->additional_info);

        return view('service.form', compact('service', 'categories', 'services', 'images'));
    }

    public function update(ServiceRequest $request, Service $service) {
        $validated = $request->validated();
        // dd($request->all());

        // dd($validated);
        

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
        if (!empty(request()->file('images')) && count(request()->file('images')) > 0) {
            foreach ($service->relationship_image()->get() as $image) {
                Storage::delete($image->image);
            }
            $service->relationship_image()->delete();

            $validated['images'] = [];

            foreach (request()->file('images') as $key => $image) {
                if (!empty($image['image'])) {
                    $validated['images'][] = [
                        'image' => $image['image']->store('public/service/' . $service->id, ['visibility' => 'public', 'directory_visibility' => 'public']),
                        'sort_order' => request('images.' . $key . '.sort_order', 0),
                    ];
                }
            }

            $service->relationship_image()->createMany($validated['images']);
        }

        // Удаление отмеченных для удаления изображений
        if ($request->has('delete_videos')) {              
            $videosToDelete = Video::whereIn('id', $request->delete_videos)->get(); 
            foreach ($videosToDelete as $video) {
                Storage::disk('public')->delete($video->path); // Удаляем файл из файловой системы
                $video->delete();                               // Удаляем запись из базы данных
            }
        }

        // Добавление новых изображений
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                #dd("test1");
                $path = $videoFile->store('video', 'public'); // Сохраняем файл в публичное хранилище
                $video = Video::create(['path' => $path]);      // Создаем запись в таблице images
                $service->videos()->attach($video->id);            // Привязываем изображение к плану через промежуточную таблицу
            }
        }
        
        
        return redirect(route('service.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Service $service) {
        if (!empty($service->image)) {
            Storage::delete($service->image);
        }

        $service->relationship_category()->delete();
        $service->relationship_service()->delete();

        foreach ($service->relationship_service()->get() as $image) {
            Storage::delete($image->image);
        }
        $service->relationship_image()->delete();

        if($service->videos){
            foreach ($service->videos as $video) {
                Storage::disk('public')->delete($video->path);
                $video->delete();
            }
        }
        $service->delete();

        return redirect(route('service.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
