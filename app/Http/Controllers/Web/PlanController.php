<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plans\Image;
use App\Models\Plans\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Storage;

class PlanController extends Controller
{
    public function index() {
        $data = Plan::where(function ($query) {
            if (!empty(request(key: 'floor_title'))) {
                $query->where('floor_title', 'LIKE', '%' . request('floor_title') . '%');
            }
        })->orderBy(request('sort', 'id'), request('order', 'DESC'))
        ->paginate(env('APP_PAGINATION_COUNT'));
        return view('plan.index', compact('data'));
    }

    public function create() {
        return view('plan.form');
    }

    public function store(PlanRequest $request) {
        $plan = Plan::create($request->validated());
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                // Сохраняем файл и добавляем запись в базу данных
                $path = $imageFile->store('images', 'public');
                $image = Image::create(['url' => $path]);
                $plan->images()->attach($image->id);
            }
        }
        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.store'));
    }

    public function edit(Plan $plan) {
        return view('plan.form', compact('plan'));
    }

    public function update(PlanRequest $request, Plan $plan) {
        $plan->update($request->validated());
        // Удаление отмеченных для удаления изображений
        if ($request->has('delete_images')) {               // Проверка, что есть изображения для удаления
            $imagesToDelete = Image::whereIn('id', $request->delete_images)->get(); // Получаем изображения по id
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->url); // Удаляем файл из файловой системы
                $image->delete();                               // Удаляем запись из базы данных
            }
        }

        // Добавление новых изображений
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $url = $imageFile->store('images', 'public'); // Сохраняем файл в публичное хранилище
                $image = Image::create(['url' => $url]);      // Создаем запись в таблице images
                $plan->images()->attach($image->id);            // Привязываем изображение к плану через промежуточную таблицу
            }
        }
        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.update'));
    }

    public function destroy(Plan $plan) {
        if($plan->images){
            foreach ($plan->images as $image) {
                Storage::disk('public')->delete($image->url);
                $image->delete();
            }
        }
        $plan->delete();
        return redirect(route('plan.index', $_GET))->with('success', __('main.alert.destroy'));
    }
}
